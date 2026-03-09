from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from .base_page import BasePage

class AssessmentPage(BasePage):
    START_TEST_BUTTON = (By.CSS_SELECTOR, "a.btn.primary")
    SUBMIT_BUTTON = (By.CSS_SELECTOR, "button[type='submit']")
    READING_OPTIONS = (By.CSS_SELECTOR, "input[type='radio']")
    ESSAY_TEXTAREA = (By.NAME, "essay")
    LISTENING_OPTIONS = (By.CSS_SELECTOR, "input[type='radio']")
    SPEAKING_SUBMIT_BUTTON = (By.ID, "submitBtn")
    FINAL_SCORE = (By.CSS_SELECTOR, ".score")

    def __init__(self, driver):
        super().__init__(driver)

    def start_assessment(self):
        self.click(self.START_TEST_BUTTON)

    def handle_interstitial(self, next_section_heading):
        proceed_btn = (By.CSS_SELECTOR, "a.btn.primary")
        try:
            # Check if we are on an intermediate page (Completed section)
            self.wait.until(EC.presence_of_element_located(proceed_btn))
            btn = self.driver.find_element(*proceed_btn)
            if "Proceed" in btn.text or "View" in btn.text or "Start" in btn.text:
                self.driver.execute_script("arguments[0].click();", btn)
        except TimeoutException:
            pass

        # Wait for the next section to actually load
        self.wait.until(EC.text_to_be_present_in_element((By.TAG_NAME, "h1"), next_section_heading))

    def complete_reading(self):
        self.wait.until(EC.text_to_be_present_in_element((By.TAG_NAME, "h1"), "Reading Test"))
        self.wait.until(EC.presence_of_element_located(self.READING_OPTIONS))
        options = self.driver.find_elements(*self.READING_OPTIONS)
        if options:
            self.driver.execute_script("arguments[0].click();", options[0])
        self.click(self.SUBMIT_BUTTON)
        self.handle_interstitial("Listening Test")

    def complete_listening(self):
        self.wait.until(EC.text_to_be_present_in_element((By.TAG_NAME, "h1"), "Listening Test"))
        self.wait.until(EC.presence_of_element_located(self.LISTENING_OPTIONS))
        options = self.driver.find_elements(*self.LISTENING_OPTIONS)
        if options:
            self.driver.execute_script("arguments[0].click();", options[0])
        self.click(self.SUBMIT_BUTTON)
        self.handle_interstitial("Writing Test")

    def complete_writing(self, content="Automated essay."):
        self.wait.until(EC.text_to_be_present_in_element((By.TAG_NAME, "h1"), "Writing Test"))
        self.wait_for_element(self.ESSAY_TEXTAREA)
        self.send_keys(self.ESSAY_TEXTAREA, content)
        self.click(self.SUBMIT_BUTTON)
        self.handle_interstitial("Speaking Test")

    def complete_speaking(self):
        # Handle cases where Speaking might be skipped or unavailable
        try:
            self.wait.until(EC.text_to_be_present_in_element((By.TAG_NAME, "h1"), "Speaking Test"))
        except TimeoutException:
            if "Results" in self.driver.page_source or "Completed" in self.driver.page_source:
                return
            raise

        # The page might not have a form if no test is found
        if "No active test found" in self.driver.page_source:
             return

        # Use presence instead of visibility because the form might be effectively invisible
        # when its submit button is hidden.
        self.wait.until(EC.presence_of_element_located((By.ID, "speakingForm")))
        self.driver.execute_script("document.getElementById('transcriptionInput').value = 'Test transcription';")
        self.driver.execute_script("document.getElementById('accuracyInput').value = '100';")
        self.driver.execute_script("document.getElementById('submitBtn').style.display = 'inline-block';")

        # Click via JS because the button might be overlapping or hidden
        btn = self.driver.find_element(*self.SPEAKING_SUBMIT_BUTTON)
        self.driver.execute_script("arguments[0].click();", btn)
