import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Admin Dashboard Navigation', () => {

    test.beforeEach(async ({ loginPage, adminDashboardPage }) => {
        await loginPage.goto();
        await loginPage.login('admin@lingopulse.com', 'admin123', 'admin');
        await adminDashboardPage.isVisible();
    });

    test('should load the dashboard correctly', async ({ adminDashboardPage }) => {
        await adminDashboardPage.isVisible();
    });

    test('should navigate to Users Management panel', async ({ adminDashboardPage, page }) => {
        await adminDashboardPage.goToUsers();
        // Add specific assertion if needed beyond what's in goToUsers.
        await expect(page.locator('#contentArea')).toBeVisible();
    });

    test('should navigate to Classes Management panel', async ({ adminDashboardPage, page }) => {
        await adminDashboardPage.goToClasses();
        await expect(page.locator('#contentArea')).toBeVisible();
    });

    test('should navigate to Content Management (Questions) panel', async ({ adminDashboardPage, page }) => {
        await adminDashboardPage.goToContent();
        await expect(page.locator('#contentArea')).toBeVisible();
    });
});
