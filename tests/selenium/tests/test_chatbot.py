import pytest
from ..pages.auth_pages import LoginPage

@pytest.mark.django_db(transaction=True)
class TestChatbot:
    @pytest.fixture(autouse=True)
    def setup(self, driver, selenium_base_url):
        self.driver = driver
        self.base_url = selenium_base_url
        self.login_page = LoginPage(driver, selenium_base_url)

    def test_strengthening_page_access(self, live_server):
        # Setup user and login
        from accounts.models import User
        email = "chat_user@example.com"
        password = "testpassword123"
        User.objects.create_user(email=email, full_name="Chat User", password=password, role='student')

        self.login_page.load()
        self.login_page.login(email, password)

        # Accessing strengthening plan
        self.driver.get(f"{live_server.url}/strengthening/")
        assert "Strengthening Plan" in self.driver.page_source
