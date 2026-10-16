<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Info } from '@lucide/vue';
import { computed } from 'vue';
import PricingCard from '@/components/sections/PricingCard.vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';

withDefaults(
    defineProps<{
        showHeading?: boolean;
        showDetailsLink?: boolean;
    }>(),
    { showHeading: true, showDetailsLink: false },
);

const { t, tm } = useI18n();
const { pageUrl } = useSiteRoutes();

const notes = computed(() => tm<string[]>('pricing.notes.items'));
</script>

<template>
    <section
        class="relative overflow-hidden bg-background-muted py-20 sm:py-24 lg:py-28"
        aria-labelledby="pricing-title"
    >
        <div
            aria-hidden="true"
            class="pointer-events-none absolute top-1/2 left-1/2 -z-0 h-[30rem] w-[60rem] -translate-x-1/2 -translate-y-1/2 rounded-full bg-sky-200/30 blur-3xl dark:bg-sky-500/5"
        />

        <div class="relative container-site">
            <SectionHeading
                v-if="showHeading"
                id="pricing-title"
                :eyebrow="t('pricing.eyebrow')"
                :title="t('pricing.title')"
                :subtitle="t('pricing.subtitle')"
            />
            <h2 v-else id="pricing-title" class="sr-only">
                {{ t('pricing.eyebrow') }}
            </h2>

            <div
                :class="[
                    'mx-auto grid max-w-5xl gap-6 md:grid-cols-2 lg:gap-8',
                    showHeading && 'mt-14 lg:mt-16',
                ]"
            >
                <div v-reveal>
                    <PricingCard plan="apartment" />
                </div>
                <div v-reveal="120">
                    <PricingCard plan="house" featured />
                </div>
            </div>

            <div
                v-reveal
                class="mx-auto mt-10 max-w-5xl rounded-3xl border border-border bg-surface p-6 sm:p-8"
            >
                <h3
                    class="flex items-center gap-2.5 font-semibold text-foreground"
                >
                    <Info
                        class="size-5 text-accent-strong"
                        aria-hidden="true"
                    />
                    {{ t('pricing.notes.title') }}
                </h3>
                <ul
                    class="mt-4 grid gap-4 text-sm leading-relaxed text-foreground-muted md:grid-cols-3"
                >
                    <li
                        v-for="note in notes"
                        :key="note"
                        class="border-l-2 border-accent/50 pl-4"
                    >
                        {{ note }}
                    </li>
                </ul>
            </div>

            <div v-if="showDetailsLink" class="mt-8 text-center">
                <Link
                    :href="pageUrl('pricing')"
                    class="inline-flex items-center gap-1.5 rounded text-sm font-medium text-accent-strong hover:underline"
                >
                    {{ t('pricing.see_details') }}
                    <ArrowRight class="size-4" aria-hidden="true" />
                </Link>
            </div>
        </div>
    </section>
</template>
