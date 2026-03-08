import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from './BasePage';

export class TeacherDashboardPage extends BasePage {
    readonly teacherTitle: Locator;
    readonly sideNav: {
        classes: Locator;
        assignments: Locator;
        grades: Locator;
        sessions: Locator;
        logout: Locator;
    };
    readonly sections: {
        main: Locator;
        classes: Locator;
        assignments: Locator;
        grades: Locator;
        sessions: Locator;
    };

    constructor(page: Page) {
        super(page);
        this.teacherTitle = page.locator('#main-page h1.teacher-title');

        this.sections = {
            main: page.locator('#main-page'),
            classes: page.locator('#classes-page'),
            assignments: page.locator('#assignments-page'),
            grades: page.locator('#grades-page'),
            sessions: page.locator('#sessions-page')
        };

        this.sideNav = {
            classes: page.locator('#classes-btn'),
            assignments: page.locator('#assignments-btn'),
            grades: page.locator('#grades-btn'),
            sessions: page.locator('#sessions-btn'),
            logout: page.locator('#logout-btn')
        };
    }

    async isVisible() {
        await expect(this.sections.main).toBeVisible({ timeout: 15000 });
        await expect(this.teacherTitle).toBeVisible();
    }

    async goBackToMain() {
        const activePage = this.page.locator('.page.active');
        const backBtn = activePage.locator('button.back-btn').first();
        await backBtn.click();
        await expect(this.sections.main).toBeVisible({ timeout: 10000 });
    }

    async goToClasses() {
        await this.sideNav.classes.click();
        await expect(this.sections.classes).toHaveClass(/active/, { timeout: 10000 });
    }

    async goToAssignments() {
        await this.sideNav.assignments.click();
        await expect(this.sections.assignments).toHaveClass(/active/, { timeout: 10000 });
    }

    async goToGrades() {
        await this.sideNav.grades.click();
        await expect(this.sections.grades).toHaveClass(/active/, { timeout: 10000 });
    }

    async goToSessions() {
        await this.sideNav.sessions.click();
        await expect(this.sections.sessions).toHaveClass(/active/, { timeout: 10000 });
    }

    async logout() {
        await this.sideNav.logout.click();
        await this.page.waitForURL(url => url.pathname === '/', { timeout: 20000 });
    }
}
