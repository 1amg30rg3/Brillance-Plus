<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';
import MobileActionBar from '@/components/layout/MobileActionBar.vue';
import SeoHead from '@/components/layout/SeoHead.vue';
import SiteFooter from '@/components/layout/SiteFooter.vue';
import SiteHeader from '@/components/layout/SiteHeader.vue';
import { useI18n } from '@/composables/useI18n';
import { printSignature } from '@/lib/signature';

const page = usePage();
const { t } = useI18n();

onMounted(() => {
    printSignature(page.props.agency);

    // Keep <html lang> in sync when the language changes without a full page load.
    watch(
        () => page.props.locale,
        (locale) => {
            document.documentElement.lang = locale;
        },
        { immediate: true },
    );
});
</script>

<template>
    <div
        class="relative flex min-h-dvh flex-col overflow-x-clip bg-background text-foreground"
    >
        <a
            href="#main-content"
            class="sr-only rounded-full bg-primary px-5 py-3 text-sm font-medium text-primary-foreground focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50"
        >
            {{ t('common.skip_to_content') }}
        </a>
        <SeoHead />
        <SiteHeader />
        <main id="main-content" tabindex="-1" class="flex-1 focus:outline-none">
            <slot />
        </main>
        <SiteFooter />
        <MobileActionBar />
    </div>
</template>
