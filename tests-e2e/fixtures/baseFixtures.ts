import { test as base } from '@playwright/test';
import { LoginPage } from '../pages/LoginPage';
import { AdminDashboardPage } from '../pages/AdminDashboardPage';
import { TeacherDashboardPage } from '../pages/TeacherDashboardPage';
import { StudentDashboardPage } from '../pages/StudentDashboardPage';

type MyFixtures = {
    loginPage: LoginPage;
    adminDashboardPage: AdminDashboardPage;
    teacherDashboardPage: TeacherDashboardPage;
    studentDashboardPage: StudentDashboardPage;
};

export const test = base.extend<MyFixtures>({
    loginPage: async ({ page }, use) => {
        await use(new LoginPage(page));
    },
    adminDashboardPage: async ({ page }, use) => {
        await use(new AdminDashboardPage(page));
    },
    teacherDashboardPage: async ({ page }, use) => {
        await use(new TeacherDashboardPage(page));
    },
    studentDashboardPage: async ({ page }, use) => {
        await use(new StudentDashboardPage(page));
    },
});

export { expect } from '@playwright/test';
