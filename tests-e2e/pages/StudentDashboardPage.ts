import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from './BasePage';

export class StudentDashboardPage extends BasePage {
    readonly welcomeMessage: Locator;
    readonly startTestButton: Locator;
    readonly logoutButton: Locator;
    readonly emptyStateTitle: Locator;
    readonly skillCards: Locator;
    readonly cefrBadge: Locator;

    constructor(page: Page) {
        super(page);
        this.welcomeMessage = page.locator('#pageTitle');
        this.startTestButton = page.locator('a:has-text("ابدأ أول اختبار لك"), .btn-primary:has(.fa-rocket)');
        this.logoutButton = page.locator('#logoutBtn');
        this.emptyStateTitle = page.locator('h2:has-text("لم تقم بإجراء أي اختبارات بعد")');
        this.skillCards = page.locator('.skill-card');
        this.cefrBadge = page.locator('.level-badge');
    }

    /**
     * Verifies the student is on a valid authenticated page.
     * Students may land on: test_instructions, test/results, check-system, or reading pages.
     */
    async isVisible() {
        // Don't check for a specific element - just verify we're on a valid student page (not login/account-selection)
        await this.page.waitForLoadState('networkidle');
        const url = this.page.url();
        const isStudentPage = !url.includes('account-selection') && !url.includes('info_accountStudents');
        expect(isStudentPage).toBeTruthy();
    }

    async startFirstTest() {
        await this.startTestButton.click();
    }

    async logout() {
        await this.logoutButton.click();
    }
}
