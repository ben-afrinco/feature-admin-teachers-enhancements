import pytest
from ..pages.auth_pages import LoginPage, RegisterPage
from ..pages.dashboard_page import DashboardPage
from django.utils.crypto import get_random_string

@pytest.mark.django_db(transaction=True)
class TestAuthentication:
    @pytest.fixture(autouse=True)
    def setup(self, driver, selenium_base_url):
        self.login_page = LoginPage(driver, selenium_base_url)
        self.register_page = RegisterPage(driver, selenium_base_url)
        self.dashboard_page = DashboardPage(driver)
        self.base_url = selenium_base_url

    def test_successful_registration(self):
        email = f"student_{get_random_string(5)}@example.com"
        self.register_page.load()
        self.register_page.register("John", "Doe", email)
        assert "/test-instructions/" in self.login_page.driver.current_url

    def test_successful_login(self, live_server):
        from accounts.models import User
        email = "testuser@example.com"
        password = "testpassword123"
        User.objects.create_user(email=email, full_name="Test User", password=password, role='student')

        self.login_page.load()
        self.login_page.login(email, password)
        assert self.login_page.driver.current_url.rstrip('/') == live_server.url

    def test_invalid_login(self):
        self.login_page.load()
        self.login_page.login("wrong@example.com", "wrongpassword")
        assert self.login_page.get_error_message() is not None

    def test_logout(self, live_server):
        from accounts.models import User
        email = "logout_test@example.com"
        password = "testpassword123"
        User.objects.create_user(email=email, full_name="Logout User", password=password, role='student')

        self.login_page.load()
        self.login_page.login(email, password)
        self.login_page.driver.get(f"{live_server.url}/logout/")
        assert self.login_page.driver.current_url.rstrip('/') == live_server.url
