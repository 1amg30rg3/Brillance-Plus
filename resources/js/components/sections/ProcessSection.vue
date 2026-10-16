<script setup lang="ts">
import {
    ClipboardList,
    Handshake,
    Info,
    MessagesSquare,
    Sparkles,
} from '@lucide/vue';
import { computed } from 'vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import { useI18n } from '@/composables/useI18n';
import type { TitledText } from '@/types';

withDefaults(defineProps<{ showHeading?: boolean }>(), { showHeading: true });

const { t, tm } = useI18n();

const icons = [ClipboardList, MessagesSquare, Handshake, Sparkles];

const steps = computed(() => tm<TitledText[]>('process.steps'));
</script>

<template>
    <section class="py-20 sm:py-24 lg:py-28" aria-labelledby="process-title">
        <div class="container-site">
            <SectionHeading
                v-if="showHeading"
                id="process-title"
                :eyebrow="t('process.eyebrow')"
                :title="t('process.title')"
                :subtitle="t('process.subtitle')"
            />
            <h2 v-else id="process-title" class="sr-only">
                {{ t('process.eyebrow') }}
            </h2>

            <div :class="['relative', showHeading && 'mt-16']">
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute top-14 right-[12%] left-[12%] hidden h-px bg-linear-to-r from-transparent via-accent/50 to-transparent lg:block"
                />
                <ol class="relative grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <li
                        v-for="(step, index) in steps"
                        :key="step.title"
                        v-reveal="index * 110"
                        class="group relative flex flex-col items-start rounded-3xl border border-border bg-surface p-7 transition duration-300 hover:-translate-y-1 hover:border-accent/40 hover:shadow-xl hover:shadow-sky-900/5 lg:items-center lg:text-center"
                    >
                        <span
                            class="relative grid size-14 place-items-center rounded-2xl bg-linear-to-br from-brand-sky to-brand-deep text-white shadow-lg shadow-sky-500/25 transition-transform duration-300 group-hover:scale-105"
                        >
                            <component
                                :is="icons[index]"
                                class="size-6"
                                aria-hidden="true"
                            />
                            <span
                                class="absolute -top-2 -right-2 grid size-6 place-items-center rounded-full border-2 border-surface bg-foreground text-[0.7rem] font-semibold text-background"
                            >
                                {{ index + 1 }}
                            </span>
                        </span>
                        <p
                            class="mt-6 text-xs font-semibold tracking-[0.16em] text-accent-strong uppercase"
                        >
                            {{ t('process.step', { number: index + 1 }) }}
                        </p>
                        <h3
                            class="mt-2 font-display text-xl font-medium text-foreground"
                        >
                            {{ step.title }}
                        </h3>
                        <p
                            class="mt-3 text-sm leading-relaxed text-foreground-muted"
                        >
                            {{ step.text }}
                        </p>
                    </li>
                </ol>
            </div>

            <p
                v-reveal
                class="mx-auto mt-10 flex max-w-3xl items-start gap-3 rounded-2xl border border-accent/30 bg-accent-soft p-5 text-sm leading-relaxed text-foreground"
            >
                <Info
                    class="mt-0.5 size-4 shrink-0 text-accent-strong"
                    aria-hidden="true"
                />
                {{ t('process.note') }}
            </p>
        </div>
    </section>
</template>
