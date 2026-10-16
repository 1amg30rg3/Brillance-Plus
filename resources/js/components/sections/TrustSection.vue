<script setup lang="ts">
import { CalendarCheck, Euro, HandHeart, Wallet } from '@lucide/vue';
import { computed } from 'vue';
import { useI18n } from '@/composables/useI18n';
import type { TitledText } from '@/types';

const { t, tm } = useI18n();

const icons = [HandHeart, Euro, CalendarCheck, Wallet];

const items = computed(() => tm<TitledText[]>('home.trust.items'));
</script>

<template>
    <section class="relative py-8 lg:py-12" aria-labelledby="trust-title">
        <h2 id="trust-title" class="sr-only">{{ t('home.trust.title') }}</h2>
        <div class="container-site">
            <ul
                class="grid gap-px overflow-hidden rounded-3xl border border-border bg-border sm:grid-cols-2 lg:grid-cols-4"
            >
                <li
                    v-for="(item, index) in items"
                    :key="item.title"
                    v-reveal="index * 80"
                    class="group flex flex-col gap-4 bg-surface p-6 transition-colors hover:bg-surface-muted sm:p-7"
                >
                    <span
                        class="grid size-11 place-items-center rounded-2xl bg-accent-soft text-accent-strong transition-transform duration-300 group-hover:-translate-y-0.5 group-hover:rotate-3"
                    >
                        <component
                            :is="icons[index]"
                            class="size-5"
                            aria-hidden="true"
                        />
                    </span>
                    <div>
                        <h3 class="font-semibold text-foreground">
                            {{ item.title }}
                        </h3>
                        <p
                            class="mt-2 text-sm leading-relaxed text-foreground-muted"
                        >
                            {{ item.text }}
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</template>
