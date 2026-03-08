import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Student Dashboard Workflows', () => {

    test.beforeEach(async ({ loginPage, page }) => {
        await loginPage.navigate();

        // Select student role
        const studentRole = page.locator('.role-btn[data-role="student"]');
        await studentRole.waitFor({ state: 'visible' });
        await studentRole.click();

        const nextBtn = page.locator('#nextBtn');
        await nextBtn.click();

        // The /info_accountStudents page is already the registration form
        // Fill out registration form for a fresh student
        await page.locator('input[name="first_name"]').fill('Test');
        await page.locator('input[name="last_name"]').fill('Student');
        const uniqueEmail = `student_${Date.now()}@example.com`;
        await page.locator('input[name="email"]').fill(uniqueEmail);
        await page.locator('input[name="email_confirm"]').fill(uniqueEmail);

        // Handle privacy checkbox (uid 1_26 in snapshot)
        const checkbox = page.locator('input[type="checkbox"]');
        await checkbox.check();

        // Submit via "Continue" button (uid 1_31 in snapshot)
        await page.locator('button:has-text("Continue"), button:has-text("استمرار")').click();

        // Wait for test_instructions page
        await page.waitForURL(/\/test_instructions/, { timeout: 15000 });

        // Click "Start Test" on instructions page (uid 2_24 in snapshot)
        await page.locator('a:has-text("Start Test"), a:has-text("ابدأ الاختبار")').click();

        // Should land on check-system or dashboard (if already taken)
        // For a fresh student, it might go to check-system
        await page.waitForURL(/check-system|info_accountStudents/, { timeout: 15000 });
    });

    test('Fresh student registration and landing on system check', async ({ page }) => {
        // Redirection check to /check-system
        await expect(page).toHaveURL(/check-system/);

        // Check for "Speaker Test" title (uid 3_5 in snapshot)
        const checkTitle = page.locator('h1:has-text("Speaker Test"), h1:has-text("فحص النظام")');
        await expect(checkTitle).toBeVisible();

        const continueBtn = page.locator('a:has-text("I can hear clearly"), a:has-text("استمرار")');
        await expect(continueBtn).toBeVisible();
    });
});
