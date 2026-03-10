import pytest
from selenium.webdriver.common.by import By
from ..pages.auth_pages import LoginPage
from ..pages.dashboard_page import DashboardPage

@pytest.mark.django_db(transaction=True)
class TestNavigation:
    @pytest.fixture(autouse=True)
    def setup(self, driver, selenium_base_url):
        self.driver = driver
        self.base_url = selenium_base_url
        self.login_page = LoginPage(driver, selenium_base_url)
        self.dashboard_page = DashboardPage(driver)

    def test_landing_page_elements(self):
        self.driver.get(self.base_url)
        assert "Welcome to" in self.driver.page_source
        assert "LingoPulse AI" in self.driver.page_source

    def test_restricted_access_student_to_teacher_dashboard(self, live_server):
        from accounts.models import User
        email = "student_nav@example.com"
        password = "testpassword123"
        User.objects.create_user(email=email, full_name="Student Nav", password=password, role='student')

        self.login_page.load()
        self.login_page.login(email, password)
        self.driver.get(f"{live_server.url}/teacher/")
        assert "/teacher/" not in self.driver.current_url

    def test_teacher_access_to_dashboard(self, live_server):
        from accounts.models import User, Teacher
        email = "teacher_nav@example.com"
        password = "testpassword123"
        user = User.objects.create_user(email=email, full_name="Teacher Nav", password=password, role='teacher')
        Teacher.objects.create(user=user)

        self.login_page.load()
        self.login_page.login(email, password)
        self.driver.get(f"{live_server.url}/teacher/")
        assert "Teacher Dashboard" in self.dashboard_page.get_teacher_heading()
