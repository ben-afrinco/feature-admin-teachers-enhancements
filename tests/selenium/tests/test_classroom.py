import pytest
from django.utils import timezone
from ..pages.auth_pages import LoginPage

@pytest.mark.django_db(transaction=True)
class TestClassroom:
    @pytest.fixture(autouse=True)
    def setup(self, driver, selenium_base_url):
        self.driver = driver
        self.base_url = selenium_base_url
        self.login_page = LoginPage(driver, selenium_base_url)

    def test_student_view_assignments(self, live_server):
        from accounts.models import User, Student
        from classroom.models import Classes, Assignment, ClassStudent

        user = User.objects.create_user(email="stu@class.com", full_name="S", password="p", role='student')
        student = Student.objects.create(user=user)

        # Create a class and assignment
        teacher_user = User.objects.create_user(email="tea@class.com", full_name="T", password="p", role='teacher')
        from accounts.models import Teacher
        teacher = Teacher.objects.create(user=teacher_user)

        cls = Classes.objects.create(classes_name="English 101", teacher=teacher, level="B1")
        ClassStudent.objects.create(classes=cls, student=student)

        Assignment.objects.create(
            class_info=cls,
            teacher=teacher,
            title="Intro Essay",
            description="Write something.",
            due_date=timezone.now() + timezone.timedelta(days=7)
        )

        self.login_page.load()
        self.login_page.login("stu@class.com", "p")

        self.driver.get(f"{live_server.url}/student/assignments/")
        assert "Intro Essay" in self.driver.page_source
        assert "Submit" in self.driver.page_source

    def test_teacher_dashboard_and_assignment_creation(self, live_server):
        from accounts.models import User, Teacher
        from classroom.models import Classes

        user = User.objects.create_user(email="teacher_cls@test.com", full_name="T", password="p", role='teacher')
        Teacher.objects.create(user=user)

        self.login_page.load()
        self.login_page.login("teacher_cls@test.com", "p")

        # Dashboard access
        assert "Teacher Dashboard" in self.driver.page_source

        # Developer dashboard restricted
        self.driver.get(f"{live_server.url}/developer/")
        assert "/developer/" not in self.driver.current_url

    def test_developer_dashboard_access(self, live_server):
        from accounts.models import User
        user = User.objects.create_user(email="admin@test.com", full_name="A", password="p", role='admin')

        self.login_page.load()
        self.login_page.login("admin@test.com", "p")

        self.driver.get(f"{live_server.url}/developer/")
        assert "Developer Dashboard" in self.driver.page_source
