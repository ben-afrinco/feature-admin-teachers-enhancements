import { test, expect } from '../../fixtures/baseFixtures';

test.describe('Landing and Public Routes', () => {

    test('should load the main landing page', async ({ page }) => {
        await page.goto('/');

        // Assert header or some defining element of LingoPulse
        const title = page.locator('h1, h2').first();
        await expect(title).toBeVisible();
    });

    test('should load how it works page', async ({ page }) => {
        await page.goto('/how-it-works');
        await expect(page.locator('body')).not.toBeEmpty();
    });

    test('should load test instructions', async ({ page }) => {
        // test_instructions is public / open for selection
        await page.goto('/test_instructions');
        await expect(page.locator('body')).not.toBeEmpty();
    });

});
