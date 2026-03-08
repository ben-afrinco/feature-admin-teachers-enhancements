import { test, expect } from '@playwright/test';
import { LoginPage } from '../../pages/LoginPage';
import { TeacherDashboardPage } from '../../pages/TeacherDashboardPage';

// Increase timeout for this multi-step workflow test
test.describe('Teacher Dashboard Workflows (Instrumented)', () => {
    let loginPage: LoginPage;
    let teacherDashboard: TeacherDashboardPage;

    test.beforeEach(async ({ page }) => {
        loginPage = new LoginPage(page);
        teacherDashboard = new TeacherDashboardPage(page);

        await test.step('Login as teacher', async () => {
            await loginPage.goto();
            await loginPage.login('teacher@lingopulse.com', 'teacher123');
            await teacherDashboard.isVisible();
        });
    });

    test('Teacher Full Workflow Scan', async ({ page }) => {
        test.setTimeout(90000); // 90s for a full workflow scan

        await test.step('Navigate: Classes', async () => {
            await teacherDashboard.goToClasses();

            const classCard = page.locator('.class-card').first();
            await expect(classCard).toBeVisible({ timeout: 5000 });
            await classCard.click();

            await expect(page.locator('#class-students-page')).toHaveClass(/active/, { timeout: 5000 });

            // back-from-students goes to classes-page
            await page.locator('#back-from-students').click();
            await expect(page.locator('#classes-page')).toHaveClass(/active/, { timeout: 5000 });

            // Now go back from classes to main
            await page.locator('#back-from-classes').click();
            await expect(page.locator('#main-page')).toBeVisible({ timeout: 5000 });
        });

        await test.step('Navigate: Assignments', async () => {
            await teacherDashboard.goToAssignments();
            await expect(page.locator('#assignment-form')).toBeVisible({ timeout: 5000 });
            await teacherDashboard.goBackToMain();
        });

        await test.step('Navigate: Grades', async () => {
            await teacherDashboard.goToGrades();
            await teacherDashboard.goBackToMain();
        });

        await test.step('Navigate: Sessions', async () => {
            await teacherDashboard.goToSessions();
            await teacherDashboard.goBackToMain();
        });

        await test.step('Logout', async () => {
            await teacherDashboard.logout();
            await expect(page).toHaveURL(url => url.pathname === '/');
        });
    });
});
