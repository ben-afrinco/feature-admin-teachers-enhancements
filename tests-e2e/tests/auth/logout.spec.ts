import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Authentication - Logout', () => {

    test('Teacher should be able to logout from dashboard', async ({ loginPage, teacherDashboardPage, page }) => {
        await loginPage.goto();
        await loginPage.login('teacher@lingopulse.com', 'teacher123', 'teacher');
        await teacherDashboardPage.isVisible();

        // Perform logout
        const logoutBtn = page.locator('form[action$="logout"] button, #logout-btn').first();
        if (await logoutBtn.isVisible()) {
            await logoutBtn.click();
        } else {
            // fallback approach: clicking a generic logout textual element
            await page.locator('text=تسجيل الخروج').first().click();
        }

        // Wait to return to landing or index page
        await page.waitForURL(/\/$/, { timeout: 10000 });
        await expect(page).toHaveURL(/\/$/); // Root path
    });
});
