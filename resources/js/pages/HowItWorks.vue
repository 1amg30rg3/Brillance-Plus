<script setup lang="ts">
import { CalendarCheck, FileText, Wallet } from '@lucide/vue';
import { computed } from 'vue';
import CtaSection from '@/components/sections/CtaSection.vue';
import FaqSection from '@/components/sections/FaqSection.vue';
import PageHero from '@/components/sections/PageHero.vue';
import ProcessSection from '@/components/sections/ProcessSection.vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import { useI18n } from '@/composables/useI18n';
import type { TitledText } from '@/types';

const { t, tm } = useI18n();

const icons = [FileText, CalendarCheck, Wallet];

const goodToKnow = computed(() =>
    tm<TitledText[]>('process.good_to_know.items'),
);
</script>

<template>
    <div>
        <PageHero
            :eyebrow="t('process.page.eyebrow')"
            :title="t('process.page.title')"
            :intro="t('process.page.intro')"
        />
        <ProcessSection :show-heading="false" />

        <section
            class="bg-background-muted py-20 sm:py-24"
            aria-labelledby="good-to-know-title"
        >
            <div class="container-site">
                <SectionHeading
                    id="good-to-know-title"
                    :title="t('process.good_to_know.title')"
                />
                <ul class="mt-12 grid gap-6 md:grid-cols-3">
                    <li
                        v-for="(item, index) in goodToKnow"
                        :key="item.title"
                        v-reveal="index * 100"
                        class="rounded-3xl border border-border bg-surface p-7"
                    >
                        <span
                            class="grid size-11 place-items-center rounded-2xl bg-accent-soft text-accent-strong"
                        >
                            <component
                                :is="icons[index]"
                                class="size-5"
                                aria-hidden="true"
                            />
                        </span>
                        <h3 class="mt-5 font-semibold text-foreground">
                            {{ item.title }}
                        </h3>
                        <p
                            class="mt-2 text-sm leading-relaxed text-foreground-muted"
                        >
                            {{ item.text }}
                        </p>
                    </li>
                </ul>
            </div>
        </section>

        <FaqSection />
        <CtaSection />
    </div>
</template>
