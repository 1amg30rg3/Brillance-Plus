<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { cn } from '@/lib/utils';
import type { LocaleCode } from '@/types';

const props = withDefaults(defineProps<{ inverse?: boolean }>(), {
    inverse: false,
});

const { locale, t } = useI18n();
const { localizedPath } = useSiteRoutes();

const languages: { code: LocaleCode; name: string }[] = [
    { code: 'fr', name: 'Français' },
    { code: 'en', name: 'English' },
];
</script>

<template>
    <nav :aria-label="t('common.language.label')">
        <ul
            :class="
                cn(
                    'inline-flex rounded-full border p-1',
                    props.inverse
                        ? 'border-white/15 bg-white/5'
                        : 'border-border bg-surface-muted',
                )
            "
        >
            <li v-for="language in languages" :key="language.code">
                <span
                    v-if="language.code === locale"
                    aria-current="true"
                    :lang="language.code"
                    :class="
                        cn(
                            'grid h-8 min-w-10 place-items-center rounded-full px-2.5 text-xs font-semibold tracking-wide',
                            props.inverse
                                ? 'bg-white text-brand-navy'
                                : 'bg-surface text-accent-strong shadow-sm',
                        )
                    "
                >
                    <span aria-hidden="true">{{
                        language.code.toUpperCase()
                    }}</span>
                    <span class="sr-only">{{ language.name }}</span>
                </span>
                <Link
                    v-else
                    :href="localizedPath(language.code)"
                    :hreflang="language.code"
                    :lang="language.code"
                    preserve-scroll
                    :class="
                        cn(
                            'grid h-8 min-w-10 place-items-center rounded-full px-2.5 text-xs font-semibold tracking-wide transition',
                            props.inverse
                                ? 'text-slate-300 hover:text-white'
                                : 'text-foreground-muted hover:text-foreground',
                        )
                    "
                >
                    <span aria-hidden="true">{{
                        language.code.toUpperCase()
                    }}</span>
                    <span class="sr-only">{{ language.name }}</span>
                </Link>
            </li>
        </ul>
    </nav>
</template>
