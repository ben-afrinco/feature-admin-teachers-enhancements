import { Page, Locator, expect } from '@playwright/test';

export class BasePage {
    constructor(protected page: Page) { }

    async navigate(path: string = '/') {
        await this.page.goto(path);
    }

    async waitForLoading() {
        // Shared loading indicator check if applicable
        // await this.page.waitForSelector('.loading-spinner', { state: 'hidden' });
    }

    async expectAlert(message: string) {
        const alert = this.page.locator(`text=${message}`);
        await expect(alert).toBeVisible();
    }
}
