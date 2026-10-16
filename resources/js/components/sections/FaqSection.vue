<script setup lang="ts">
import { ChevronDown } from '@lucide/vue';
import { computed } from 'vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';

type FaqItem = { question: string; answer: string };

const { t, tm } = useI18n();
const { business, formattedHourlyPriceFrom } = useBusiness();

const replacements = computed(() => ({
    apartment: formattedHourlyPriceFrom('apartment') ?? '',
    house: formattedHourlyPriceFrom('house') ?? '',
    phone: business.value.phoneDisplay,
}));

function interpolate(text: string): string {
    return Object.entries(replacements.value).reduce(
        (result, [name, value]) => result.replaceAll(`:${name}`, value),
        text,
    );
}

const items = computed(() =>
    tm<FaqItem[]>('faq.items').map((item) => ({
        question: item.question,
        answer: interpolate(item.answer),
    })),
);
</script>

<template>
    <section class="py-20 sm:py-24 lg:py-28" aria-labelledby="faq-title">
        <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-28">
                    <SectionHeading
                        id="faq-title"
                        align="start"
                        :eyebrow="t('faq.eyebrow')"
                        :title="t('faq.title')"
                        :subtitle="t('faq.subtitle')"
                    />
                    <p class="mt-6 text-sm text-foreground-muted">
                        {{ t('faq.more_questions') }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-3 lg:col-span-8">
                <!-- Native disclosure widgets: keyboard and screen-reader friendly, and functional without JavaScript. -->
                <details
                    v-for="(item, index) in items"
                    :key="item.question"
                    v-reveal="index * 50"
                    class="faq-item group rounded-2xl border border-border bg-surface transition-colors open:border-accent/40 open:bg-surface-muted/60"
                >
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-6 rounded-2xl px-6 py-5 font-medium text-foreground transition-colors hover:text-accent-strong [&::-webkit-details-marker]:hidden"
                    >
                        {{ item.question }}
                        <span
                            class="grid size-8 shrink-0 place-items-center rounded-full border border-border bg-surface text-foreground-muted transition-transform duration-300 group-open:rotate-180 group-open:border-accent/40 group-open:text-accent-strong"
                        >
                            <ChevronDown class="size-4" aria-hidden="true" />
                        </span>
                    </summary>
                    <p
                        class="px-6 pb-6 text-sm leading-relaxed text-foreground-muted sm:text-base"
                    >
                        {{ item.answer }}
                    </p>
                </details>
            </div>
        </div>
    </section>
</template>

<style scoped>
@supports (interpolate-size: allow-keywords) {
    .faq-item {
        interpolate-size: allow-keywords;
    }

    .faq-item::details-content {
        block-size: 0;
        overflow: clip;
        transition:
            block-size 0.3s ease,
            content-visibility 0.3s allow-discrete;
    }

    .faq-item[open]::details-content {
        block-size: auto;
    }
}
</style>
