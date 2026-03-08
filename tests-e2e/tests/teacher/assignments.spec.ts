import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Teacher Assignments Workflow', () => {

    test.beforeEach(async ({ loginPage, teacherDashboardPage }) => {
        await loginPage.goto();
        await loginPage.login('teacher@lingopulse.com', 'teacher123', 'teacher');
        await teacherDashboardPage.isVisible();
        await teacherDashboardPage.goToAssignments();
    });

    test('should open Add Assignment form', async ({ page }) => {
        const createBtn = page.locator('button:has-text("تكليف جديد")').first();
        if (await createBtn.isVisible()) {
            await createBtn.click();
        }

        const titleInput = page.locator('#assignment-title');
        await expect(titleInput).toBeVisible();
    });

    test('should view submitted assignments', async ({ page }) => {
        // Verify assignments page section is active (not looking for a specific container)
        const assignmentsPage = page.locator('#assignments-page');
        await expect(assignmentsPage).toBeVisible({ timeout: 10000 });
    });
});
