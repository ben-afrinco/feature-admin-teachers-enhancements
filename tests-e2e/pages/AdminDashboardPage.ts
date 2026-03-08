import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from './BasePage';

export class AdminDashboardPage extends BasePage {
    readonly adminTitle: Locator;
    readonly sideNav: {
        users: Locator;
        classes: Locator;
        content: Locator;
        logout: Locator;
    };

    constructor(page: Page) {
        super(page);
        this.adminTitle = page.locator('#brandSub');

        this.sideNav = {
            users: page.locator('#navUsers'),
            classes: page.locator('#navCourses'),
            content: page.locator('#navContent'),
            logout: page.locator('#logoutBtn')
        };
    }

    async isVisible() {
        await expect(this.page).toHaveURL(/developer/);
    }

    async goToUsers() {
        await this.sideNav.users.click();
        await expect(this.page.locator('#contentArea')).toBeVisible();
    }

    async goToClasses() {
        await this.sideNav.classes.click();
        await expect(this.page.locator('#contentArea')).toBeVisible();
    }

    async goToContent() {
        await this.sideNav.content.click();
        await expect(this.page.locator('#contentArea')).toBeVisible();
    }
}
