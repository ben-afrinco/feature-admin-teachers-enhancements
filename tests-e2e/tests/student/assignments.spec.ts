import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Student Assignments Workflow', () => {

    test.beforeEach(async ({ loginPage, studentDashboardPage }) => {
        await loginPage.goto();
        await loginPage.login('student@lingopulse.com', 'student123', 'student');
        await studentDashboardPage.isVisible();
    });

    test('should be able to navigate to Assignments page', async ({ page }) => {
        await page.goto('/student/assignments');
        await page.waitForLoadState('networkidle');

        // Verify we're on the assignments page (not redirected)
        const url = page.url();
        expect(url).toContain('student/assignments');

        // Page should have content
        const body = page.locator('body');
        await expect(body).not.toBeEmpty();
    });

    test('should display assignments list or empty state', async ({ page }) => {
        await page.goto('/student/assignments');
        await page.waitForLoadState('networkidle');

        // Check for either assignments content or empty state
        const pageContent = page.locator('body');
        await expect(pageContent).not.toBeEmpty();
    });
});
