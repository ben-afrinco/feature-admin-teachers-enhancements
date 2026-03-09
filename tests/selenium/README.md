# LingoPulse AI - Selenium Automation Framework

This directory contains the enterprise-grade automated browser testing system for LingoPulse AI.

## Architecture

The framework follows the **Page Object Model (POM)** pattern for maintainability and scalability.

- `pages/`: Contains page classes that encapsulate the UI structure and interactions.
- `tests/`: Contains test suites categorized by functionality (Auth, Navigation, Assessment, etc.).
- `conftest.py`: Manages the WebDriver lifecycle and test fixtures.
- `screenshots/`: Automatically generated screenshots on test failures.

## Prerequisites

- Python 3.12+
- Google Chrome and/or Mozilla Firefox installed.
- Drivers are managed automatically via `webdriver-manager`.

## Installation

```bash
pip install -r requirements.txt
pip install selenium webdriver-manager pytest-selenium pytest-html
```

## Running Tests

### All Tests (Default: Chrome Headless)
```bash
APP_KEY=secret python -m pytest tests/selenium/tests/
```

### With HTML Report
```bash
APP_KEY=secret python -m pytest tests/selenium/tests/ --html=report.html
```

### Specific Browser
```bash
APP_KEY=secret python -m pytest tests/selenium/tests/ --browser=firefox
```

### Non-Headless Mode
```bash
APP_KEY=secret python -m pytest tests/selenium/tests/ --headless=false
```

## Test Coverage

1. **Authentication**: Registration, Login (Valid/Invalid), Logout.
2. **Navigation**: Role-based access control, Landing page elements.
3. **Assessment Flow**: Complete student journey (Reading, Listening, Writing, Speaking).
4. **Form Validation**: Empty fields, invalid email formats.
5. **Error Handling**: 404 pages, unauthorized access redirects.
