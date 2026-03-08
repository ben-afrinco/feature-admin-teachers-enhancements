import { test, expect } from '../../fixtures/baseFixtures';

/**
 * Authentication & Session Management Tests
 * 
 * Verifies the login and logout flows for all three system roles:
 * - Teacher: Redirects to /teacher dashboard
 * - Admin: Redirects to /developer administrator panel
 * - Student: Handles registration/onboarding redirection
 */
test.describe('Authentication & Session Management', () => {

    test.beforeEach(async ({ loginPage }) => {
        await loginPage.navigate();
    });

    test('Teacher should be able to login with valid credentials', async ({ page, loginPage }) => {
        /**
         * Validates successful teacher authentication.
         * Expects redirection to the teacher-specific dashboard.
         */
        await loginPage.goto();
        // loginPage.login() handles role selection, modal, and form submission
        await loginPage.login('teacher@lingopulse.com', 'teacher123', 'teacher');
        await page.waitForTimeout(2000);
        await page.screenshot({ path: 'test-results/debug-teacher-login.png' });
        await expect(page).toHaveURL(/teacher/);
    });

    test('Admin should be able to login with valid credentials', async ({ page, loginPage }) => {
        /**
         * Validates successful admin authentication.
         * Expects redirection to the developer/admin dashboard.
         */
        await loginPage.goto();
        await loginPage.login('admin@lingopulse.com', 'admin123', 'admin');
        await page.waitForTimeout(2000);
        await page.screenshot({ path: 'test-results/debug-admin-login.png' });
        await expect(page).toHaveURL(/developer/);
    });

    test('Should show error for invalid credentials', async ({ page, loginPage }) => {
        /**
         * Verifies UI feedback for failed authentication attempts.
         */
        await loginPage.login('wrong@example.com', 'wrongpassword', 'teacher');
        // Check for the error message in the modal
        await expect(page.locator('#loginModal')).toContainText('البريد الإلكتروني أو كلمة المرور غير صحيحة');
    });

    test('Student login flow (direct registration)', async ({ page }) => {
        /**
         * Verifies the student entry point.
         * Unlike staff, students are routed to an registration/onboarding form
         * instead of a standard login modal.
         */
        await page.locator('.role-btn[data-role="student"]').click();
        await page.locator('#nextBtn').click();
        // Student role redirects directly to info-students registration page
        await expect(page).toHaveURL(/info_accountStudents/);
    });
});

