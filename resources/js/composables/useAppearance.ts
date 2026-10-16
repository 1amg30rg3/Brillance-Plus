import { onMounted, readonly, ref } from 'vue';

export type Appearance = 'light' | 'dark' | 'system';

const STORAGE_KEY = 'appearance';

/*
 * Module-level state shared by every theme switcher. It is only ever changed
 * in the browser, so server-side renders always start from "system".
 */
const appearance = ref<Appearance>('system');
let isInitialized = false;

function systemPrefersDark(): boolean {
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function applyAppearance(value: Appearance): void {
    const isDark =
        value === 'dark' || (value === 'system' && systemPrefersDark());

    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
}

function readStoredAppearance(): Appearance {
    try {
        const stored = window.localStorage.getItem(STORAGE_KEY);

        return stored === 'light' || stored === 'dark' ? stored : 'system';
    } catch {
        return 'system';
    }
}

function storeAppearance(value: Appearance): void {
    try {
        window.localStorage.setItem(STORAGE_KEY, value);
    } catch {
        // Storage can be unavailable (private browsing, blocked cookies): the choice then lasts for the visit.
    }
}

function withThemeTransition(update: () => void): void {
    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;

    if (prefersReducedMotion || !document.startViewTransition) {
        update();

        return;
    }

    document.startViewTransition(update);
}

function initializeAppearance(): void {
    if (isInitialized) {
        return;
    }

    isInitialized = true;
    appearance.value = readStoredAppearance();
    applyAppearance(appearance.value);

    window
        .matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', () => {
            if (appearance.value === 'system') {
                withThemeTransition(() => applyAppearance('system'));
            }
        });

    window.addEventListener('storage', (event) => {
        if (event.key === STORAGE_KEY) {
            appearance.value = readStoredAppearance();
            applyAppearance(appearance.value);
        }
    });
}

/**
 * The light / dark / system theme preference, persisted in localStorage.
 * The initial theme is applied before paint by an inline script in app.blade.php.
 */
export function useAppearance() {
    onMounted(initializeAppearance);

    function updateAppearance(value: Appearance): void {
        appearance.value = value;
        storeAppearance(value);
        withThemeTransition(() => applyAppearance(value));
    }

    return { appearance: readonly(appearance), updateAppearance };
}
