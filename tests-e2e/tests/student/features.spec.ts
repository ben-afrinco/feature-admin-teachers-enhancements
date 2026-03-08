import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Student Features & Practice', () => {

    test.beforeEach(async ({ loginPage }) => {
        await loginPage.goto();
        await loginPage.login('student@lingopulse.com', 'student123', 'student');
    });

    test('should load practice pages correctly', async ({ page }) => {
        // Test reading practice
        await page.goto('/practice/readings');
        await page.waitForLoadState('networkidle');
        await expect(page.locator('body')).not.toBeEmpty();

        // Test listening practice
        await page.goto('/practice/listenings');
        await page.waitForLoadState('networkidle');
        await expect(page.locator('body')).not.toBeEmpty();

        // Test strengthening page
        await page.goto('/strengthening');
        await page.waitForLoadState('networkidle');
        await expect(page.locator('body')).not.toBeEmpty();
    });

    test('should load writing practice page', async ({ page }) => {
        await page.goto('/practice/writings');
        await page.waitForLoadState('networkidle');
        await expect(page.locator('body')).not.toBeEmpty();
    });

    test('should load speaking practice page', async ({ page }) => {
        await page.goto('/practice/speakings');
        await page.waitForLoadState('networkidle');
        await expect(page.locator('body')).not.toBeEmpty();
    });
});
