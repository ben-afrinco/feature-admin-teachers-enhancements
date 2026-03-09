import pytest
from selenium.webdriver.common.by import By

@pytest.mark.django_db(transaction=True)
class TestErrors:
    @pytest.fixture(autouse=True)
    def setup(self, driver, selenium_base_url):
        self.driver = driver
        self.base_url = selenium_base_url

    def test_404_page(self):
        self.driver.get(f"{self.base_url}/non-existent-page/")
        assert "404" in self.driver.page_source or "Not Found" in self.driver.page_source

    def test_unauthorized_access_teacher_dashboard(self, live_server):
        # Accessing teacher dashboard without login
        self.driver.get(f"{live_server.url}/teacher/")
        # Should redirect to login or show error
        assert "/teacher/" not in self.driver.current_url
