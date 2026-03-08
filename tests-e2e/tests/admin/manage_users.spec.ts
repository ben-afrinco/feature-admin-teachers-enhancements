import { test, expect } from '../../fixtures/baseFixtures';

/**
 * Admin User Management Tests
 * 
 * Verifies the administrative controls for managing the platform's user base.
 * Focuses on UI interactions for adding new users and modal management.
 */
test.describe('Admin Manage Users Workflow', () => {

    test.beforeEach(async ({ loginPage, adminDashboardPage }) => {
        await loginPage.goto();
        await loginPage.login('admin@lingopulse.com', 'admin123', 'admin');
        await adminDashboardPage.isVisible();
        await adminDashboardPage.goToUsers();
    });

    test('should open Add User modal', async ({ page }) => {
        /**
         * Validates the user creation form accessibility.
         */
        const addUserBtn = page.locator('#addUserBtn');
        await addUserBtn.click();

        const modal = page.locator('#addUserModal');
        await expect(modal).toBeVisible();
        await expect(modal.locator('#addUserModalTitle')).toContainText('إضافة مستخدم');
    });

    test('should close Add User modal via cancel', async ({ page }) => {
        /**
         * Verifies the modal dismissal logic to ensure UI state resets correctly.
         */
        const addUserBtn = page.locator('#addUserBtn');
        await addUserBtn.click();

        const modal = page.locator('#addUserModal');
        await expect(modal).toBeVisible();

        // Wait for Close button inside that modal
        const closeBtn = modal.locator('#closeAddUserModal');
        await closeBtn.click();

        await expect(modal).not.toBeVisible();
    });
});

