import pytest
import os
from selenium import webdriver
from selenium.webdriver.chrome.service import Service as ChromeService
from selenium.webdriver.chrome.options import Options as ChromeOptions
from webdriver_manager.chrome import ChromeDriverManager

def pytest_addoption(parser):
    parser.addoption("--browser", action="store", default="chrome", help="Browser to run tests on (chrome, firefox)")
    parser.addoption("--headless", action="store", default="true", help="Run in headless mode")

@pytest.fixture(scope="session")
def browser_config(request):
    return {
        "browser": request.config.getoption("--browser").lower(),
        "headless": request.config.getoption("--headless").lower() == "true",
        "window_size": (1920, 1080),
    }

@pytest.fixture(scope="function")
def driver(browser_config):
    browser = browser_config["browser"]
    headless = browser_config["headless"]
    width, height = browser_config["window_size"]

    if browser == "chrome":
        from selenium.webdriver.chrome.options import Options as ChromeOptions
        from selenium.webdriver.chrome.service import Service as ChromeService
        from webdriver_manager.chrome import ChromeDriverManager

        options = ChromeOptions()
        if headless:
            options.add_argument("--headless")
        options.add_argument("--no-sandbox")
        options.add_argument("--disable-dev-shm-usage")
        options.add_argument(f"--window-size={width},{height}")
        service = ChromeService(ChromeDriverManager().install())
        driver = webdriver.Chrome(service=service, options=options)

    elif browser == "firefox":
        from selenium.webdriver.firefox.options import Options as FirefoxOptions
        from selenium.webdriver.firefox.service import Service as FirefoxService
        from webdriver_manager.firefox import GeckoDriverManager

        options = FirefoxOptions()
        if headless:
            options.add_argument("--headless")
        options.add_argument(f"--width={width}")
        options.add_argument(f"--height={height}")
        service = FirefoxService(GeckoDriverManager().install())
        driver = webdriver.Firefox(service=service, options=options)

    elif browser == "edge":
        from selenium.webdriver.edge.options import Options as EdgeOptions
        from selenium.webdriver.edge.service import Service as EdgeService
        from webdriver_manager.microsoft import EdgeChromiumDriverManager

        options = EdgeOptions()
        if headless:
            options.add_argument("--headless")
        options.add_argument("--no-sandbox")
        options.add_argument("--disable-dev-shm-usage")
        options.add_argument(f"--window-size={width},{height}")
        service = EdgeService(EdgeChromiumDriverManager().install())
        driver = webdriver.Edge(service=service, options=options)

    else:
        raise ValueError(f"Unsupported browser: {browser}")

    yield driver
    driver.quit()

@pytest.fixture
def selenium_base_url(live_server):
    return live_server.url

@pytest.hookimpl(tryfirst=True, hookwrapper=True)
def pytest_runtest_makereport(item, call):
    outcome = yield
    report = outcome.get_result()

    if report.when == 'call' and report.failed:
        driver = item.funcargs.get('driver')
        if driver:
            if not os.path.exists('screenshots'):
                os.makedirs('screenshots')
            screenshot_path = f"screenshots/{item.name}.png"
            driver.save_screenshot(screenshot_path)

            # Integrate with pytest-html if available
            pytest_html = item.config.pluginmanager.getplugin('html')
            if pytest_html:
                extra = getattr(report, 'extra', [])
                # Handle relative path for the report
                extra.append(pytest_html.extras.image(screenshot_path))
                report.extra = extra

            print(f"Screenshot saved to {screenshot_path}")
