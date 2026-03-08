import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from './BasePage';

export class LoginPage extends BasePage {
    readonly emailInput: Locator;
    readonly passwordInput: Locator;
    readonly loginButton: Locator;
    readonly forgotPasswordLink: Locator;

    constructor(page: Page) {
        super(page);
        this.emailInput = page.locator('#loginModal input[name="email"]');
        this.passwordInput = page.locator('#loginModal input[name="password"]');
        this.loginButton = page.locator('#loginSubmitBtn');
        this.forgotPasswordLink = page.locator('#forgotPwdLink');
    }

    async navigate() {
        await this.page.goto('/account-selection');
    }

    async goto() {
        await this.navigate();
    }

    /**
     * Logs in as the given role.
     * - Admin/Teacher: Uses the #loginModal on /account-selection
     * - Student: Uses a direct POST to /auth/login (since the UI redirects students 
     *   to a registration form, not a login modal)
     */
    async login(email: string, password: string, role: 'teacher' | 'admin' | 'student' = 'teacher') {
        if (role === 'student') {
            // Student flow: POST directly to /auth/login via the browser context
            // This sets the session cookie correctly
            await this.page.request.post('/auth/login', {
                form: {
                    email: email,
                    password: password,
                    _token: await this.getCsrfToken(),
                },
            });
            // Reload the page so the session cookie takes effect
            await this.page.goto('/test/results');
            await this.page.waitForLoadState('networkidle');
        } else {
            // Admin/Teacher flow: use the login modal
            const roleBtn = this.page.locator(`.role-btn[data-role="${role}"]`);
            await expect(roleBtn).toBeVisible({ timeout: 10000 });
            await roleBtn.click({ force: true });

            const nextBtn = this.page.locator('#nextBtn');
            await expect(nextBtn).toBeVisible({ timeout: 10000 });
            await nextBtn.click({ force: true });

            const loginModal = this.page.locator('#loginModal');
            await expect(loginModal).toBeVisible({ timeout: 15000 });
            await this.page.waitForTimeout(500);

            await this.emailInput.fill(email);
            await this.passwordInput.fill(password);
            await this.loginButton.click({ force: true });

            await this.page.waitForLoadState('networkidle');
        }
    }

    /**
     * Gets the CSRF token from the /account-selection page
     */
    private async getCsrfToken(): Promise<string> {
        // Navigate to a page that has the CSRF token if not already there
        const currentUrl = this.page.url();
        if (!currentUrl.includes('account-selection') && !currentUrl.includes('localhost')) {
            await this.page.goto('/account-selection');
        }

        // Extract CSRF token from any meta tag or form
        const token = await this.page.evaluate(() => {
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) return meta.getAttribute('content') || '';
            const input = document.querySelector('input[name="_token"]');
            if (input) return (input as HTMLInputElement).value || '';
            return '';
        });
        return token;
    }

    async expectAlert(message: string) {
        const alert = this.page.locator('div:has-text("' + message + '")');
        await expect(alert).toBeVisible();
    }

    async logout() {
        await this.page.locator('form[action$="/logout"] button, button:has-text("تسجيل الخروج"), button:has-text("Logout")').click();
    }

    async goToForgotPassword() {
        await this.forgotPasswordLink.click();
    }
}
