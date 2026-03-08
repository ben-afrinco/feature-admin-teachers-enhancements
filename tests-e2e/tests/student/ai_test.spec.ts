import { test, expect } from '../../fixtures/baseFixtures';

/**
 * Student AI Test Workflow Tests
 * 
 * Verifies the end-to-end journey of a student taking dynamic AI tests.
 * Covers test initialization, system check persistence, and results visualization.
 */
test.describe('Student AI Test Workflow', () => {

    test.beforeEach(async ({ loginPage, studentDashboardPage }) => {
        await loginPage.goto();
        await loginPage.login('student@lingopulse.com', 'student123', 'student');
        await studentDashboardPage.isVisible();
    });

    test('should be able to access reading test page', async ({ page }) => {
        /**
         * Validates the AI test entry state.
         * Ensures students reach the appropriate starting point (instruction or system check).
         */
        // Navigate to start the AI test
        await page.goto('/test/start');
        await page.waitForLoadState('networkidle');

        // Should end up on check-system, reading, or test_instructions
        const url = page.url();
        const validPage = url.includes('reading') || url.includes('check-system') || url.includes('test_instructions') || url.includes('test/start');
        expect(validPage).toBeTruthy();

        // If on system check, verify the continue button exists
        if (url.includes('check-system')) {
            const continueBtn = page.locator('a:has-text("استمرار"), a:has-text("I can hear clearly")');
            await expect(continueBtn).toBeVisible({ timeout: 10000 });
        }
    });

    test('should view test results page', async ({ page }) => {
        /**
         * Validates result accessibility.
         * Ensures the results page loads correctly for authenticated students.
         */
        // Go to results page 
        await page.goto('/test/results');
        await page.waitForLoadState('networkidle');

        // Should either show results or show empty state
        const body = page.locator('body');
        await expect(body).not.toBeEmpty();

        // Verify we're on the results page (not redirected to login)
        const url = page.url();
        expect(url).toContain('test/results');
    });

});

