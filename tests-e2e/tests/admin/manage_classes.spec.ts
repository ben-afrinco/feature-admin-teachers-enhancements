import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Admin Manage Classes Workflow', () => {

    test.beforeEach(async ({ loginPage, adminDashboardPage }) => {
        await loginPage.goto();
        await loginPage.login('admin@lingopulse.com', 'admin123', 'admin');
        await adminDashboardPage.isVisible();
        await adminDashboardPage.goToClasses();
    });

    test('should open Add Course modal', async ({ page }) => {
        const addCourseBtn = page.locator('#addCourseBtn');
        await addCourseBtn.click();

        const modal = page.locator('#addCourseModal');
        await expect(modal).toBeVisible();
        await expect(modal.locator('#addCourseModalTitle')).toContainText('إضافة دورة');
    });
});
