from selenium.webdriver.common.by import By
from .base_page import BasePage

class LoginPage(BasePage):
    EMAIL_INPUT = (By.NAME, "email")
    PASSWORD_INPUT = (By.NAME, "password")
    LOGIN_BUTTON = (By.CSS_SELECTOR, "button[type='submit']")
    ERROR_MESSAGE = (By.CSS_SELECTOR, "p[style='color: red;']")

    def __init__(self, driver, base_url):
        super().__init__(driver)
        self.url = f"{base_url}/auth/login/"

    def load(self):
        self.driver.get(self.url)

    def login(self, email, password):
        self.send_keys(self.EMAIL_INPUT, email)
        self.send_keys(self.PASSWORD_INPUT, password)
        self.click(self.LOGIN_BUTTON)

    def get_error_message(self):
        return self.get_text(self.ERROR_MESSAGE)

class RegisterPage(BasePage):
    FIRST_NAME_INPUT = (By.NAME, "first_name")
    LAST_NAME_INPUT = (By.NAME, "last_name")
    EMAIL_INPUT = (By.NAME, "email")
    START_BUTTON = (By.CSS_SELECTOR, "button[type='submit']")

    def __init__(self, driver, base_url):
        super().__init__(driver)
        self.url = f"{base_url}/register/"

    def load(self):
        self.driver.get(self.url)

    def register(self, first_name, last_name, email):
        self.send_keys(self.FIRST_NAME_INPUT, first_name)
        self.send_keys(self.LAST_NAME_INPUT, last_name)
        self.send_keys(self.EMAIL_INPUT, email)
        self.click(self.START_BUTTON)
