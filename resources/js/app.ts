import { createInertiaApp } from '@inertiajs/vue3';
import { vReveal } from '@/directives/reveal';
import SiteLayout from '@/layouts/SiteLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Brillance Plus';

void createInertiaApp({
    // Page titles are composed on the server (see App\Support\PageMetadata).
    title: (title) => title || appName,
    layout: () => SiteLayout,
    withApp: (app) => {
        app.directive('focus', {
            mounted: (el: HTMLElement, shouldFocus) => {
                if (shouldFocus.value !== false) {
                    el.focus();
                }
            },
        });

        app.directive('reveal', vReveal);
    },
    progress: {
        color: '#38BDF8',
    },
});
