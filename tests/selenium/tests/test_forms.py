import pytest
from selenium.webdriver.common.by import By
from ..pages.auth_pages import LoginPage, RegisterPage

@pytest.mark.django_db(transaction=True)
class TestForms:
    @pytest.fixture(autouse=True)
    def setup(self, driver, selenium_base_url):
        self.driver = driver
        self.base_url = selenium_base_url
        self.login_page = LoginPage(driver, selenium_base_url)
        self.register_page = RegisterPage(driver, selenium_base_url)

    def test_login_empty_fields(self):
        self.login_page.load()
        self.login_page.click(self.login_page.LOGIN_BUTTON)

        # Check for HTML5 validation or just stay on same page
        assert self.driver.current_url == self.login_page.url

    def test_registration_invalid_email(self):
        self.register_page.load()
        # registration(self, first_name, last_name, email)
        self.register_page.register("John", "Doe", "not-an-email")

        # Should not proceed to instructions
        assert "/test-instructions/" not in self.driver.current_url

    def test_registration_missing_fields(self):
        self.register_page.load()
        self.register_page.click(self.register_page.START_BUTTON)
        assert "/test-instructions/" not in self.driver.current_url
