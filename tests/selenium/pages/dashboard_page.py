from selenium.webdriver.common.by import By
from .base_page import BasePage

class DashboardPage(BasePage):
    STUDENT_GREETING = (By.ID, "mainTitle")
    TEACHER_HEADING = (By.XPATH, "//h1[text()='Teacher Dashboard']")

    def __init__(self, driver):
        super().__init__(driver)

    def get_teacher_heading(self):
        return self.get_text(self.TEACHER_HEADING)
