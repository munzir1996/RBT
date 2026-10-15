import { createInertiaApp, router } from '@inertiajs/svelte';
import AppLayout from '@/layouts/AppLayout.svelte';
import AuthLayout from '@/layouts/AuthLayout.svelte';
import SettingsLayout from '@/layouts/settings/Layout.svelte';
import { initializeFlashToast } from '@/lib/flash-toast';
import { initializeTheme } from '@/lib/theme.svelte';

// Tell TypeScript about the global Google Analytics gtag function on window
declare global {
    interface Window {
        gtag?: (...args: any[]) => void;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Ring Back Tone';

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'Welcome':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },
    progress: {
        color: '#4B5563',
    },
});

// Track page views on every Inertia page navigation
router.on('finish', () => {
    if (typeof window.gtag === 'function') {
        window.gtag('config', 'G-NMR1ZXE89T', {
            page_path: window.location.pathname,
        });
    }
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
