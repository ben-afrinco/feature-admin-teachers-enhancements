import { FullConfig } from '@playwright/test';
import { execSync } from 'child_process';

async function globalSetup(config: FullConfig) {
    console.log('--- Global Setup: Initializing Test Environment ---');

    try {
        // Reset and seed database using Artisan
        console.log('Migration and Seeding...');
        execSync('php artisan migrate:fresh --seed', {
            cwd: '../', // Run from Laravel root
            stdio: 'inherit'
        });

        console.log('Environment Ready.');
    } catch (error) {
        console.error('Global Setup Failed:', error);
        process.exit(1);
    }
}

export default globalSetup;
