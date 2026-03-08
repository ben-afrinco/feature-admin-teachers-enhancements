import { test, expect } from '../../fixtures/baseFixtures';

/**
 * Teacher Sessions Workflow Tests
 * 
 * Verifies functionality related to online virtual classrooms:
 * - Session dashboard visibility
 * - Interactive session scheduling form
 */
test.describe('Teacher Sessions Workflow', () => {

    test.beforeEach(async ({ loginPage, teacherDashboardPage }) => {
        await loginPage.goto();
        await loginPage.login('teacher@lingopulse.com', 'teacher123', 'teacher');
        await teacherDashboardPage.isVisible();
        await teacherDashboardPage.goToSessions();
    });

    test('should be able to view online sessions page', async ({ page }) => {
        /**
         * Verifies the online sessions management section renders correctly.
         */
        // Verify the sessions page section is active
        const sessionsPage = page.locator('#sessions-page');
        await expect(sessionsPage).toBeVisible({ timeout: 10000 });
    });

    test('should open Create Session schedule form', async ({ page }) => {
        /**
         * Validates the "New Session" interactive modal/form opening logic.
         */
        const createSessionBtn = page.locator('button:has-text("جلسة جديدة")').first();
        if (await createSessionBtn.isVisible()) {
            await createSessionBtn.click();
        }

        const sessionForm = page.locator('#create-session-form');
        await expect(sessionForm).toBeVisible();
    });
});

