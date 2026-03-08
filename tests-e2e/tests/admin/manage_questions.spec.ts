import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Admin Manage Questions Workflow', () => {

    test.beforeEach(async ({ loginPage, adminDashboardPage }) => {
        await loginPage.goto();
        await loginPage.login('admin@lingopulse.com', 'admin123', 'admin');
        await adminDashboardPage.isVisible();
        await adminDashboardPage.goToContent();
    });

    test('should open Add Question modal', async ({ page }) => {
        const addQuestionBtn = page.locator('#addQuestionBtn');
        await addQuestionBtn.click();

        const modal = page.locator('#addQuestionModal');
        await expect(modal).toBeVisible();
        await expect(modal.locator('#addQuestionModalTitle')).toContainText('إضافة سؤال');
    });
});
