<script setup lang="ts">
import { Check, Gem, Layers, Sparkles } from '@lucide/vue';
import { computed } from 'vue';
import { useI18n } from '@/composables/useI18n';
import { cn } from '@/lib/utils';
import type { PackageKey } from '@/types';

const props = withDefaults(
    defineProps<{
        package: PackageKey;
        recommended?: boolean;
    }>(),
    { recommended: false },
);

const { t, tm } = useI18n();

const icons = { essential: Layers, comfort: Sparkles, premium: Gem };

const key = computed(() => props.package);
const features = computed(() =>
    tm<string[]>(`packages.items.${key.value}.features`),
);
</script>

<template>
    <article
        :class="
            cn(
                'group relative flex h-full flex-col rounded-[2rem] border bg-surface p-8 transition duration-300 ease-out hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-sky-900/10 dark:hover:shadow-black/40',
                props.recommended
                    ? 'border-accent/60 shadow-xl ring-1 shadow-sky-900/10 ring-accent/40 lg:-my-4 lg:py-12'
                    : 'border-border hover:border-accent/40',
            )
        "
    >
        <p
            v-if="props.recommended"
            class="absolute -top-3.5 left-8 inline-flex items-center gap-1.5 rounded-full bg-primary px-3.5 py-1 text-xs font-semibold text-primary-foreground shadow-md"
        >
            <Sparkles class="size-3" aria-hidden="true" />
            {{ t('packages.recommended') }}
        </p>

        <span
            class="grid size-12 place-items-center rounded-2xl bg-accent-soft text-accent-strong transition-transform duration-300 group-hover:scale-110"
        >
            <component :is="icons[key]" class="size-6" aria-hidden="true" />
        </span>

        <h3 class="mt-6 font-display text-2xl font-medium text-foreground">
            {{ t(`packages.items.${key}.name`) }}
        </h3>
        <p class="mt-1 text-sm font-medium text-accent-strong">
            {{ t(`packages.items.${key}.tagline`) }}
        </p>
        <p class="mt-4 text-sm leading-relaxed text-foreground-muted">
            {{ t(`packages.items.${key}.description`) }}
        </p>

        <ul class="mt-6 flex flex-col gap-2.5">
            <li
                v-for="feature in features"
                :key="feature"
                class="flex items-start gap-2.5 text-sm text-foreground"
            >
                <Check
                    class="mt-0.5 size-4 shrink-0 text-accent"
                    aria-hidden="true"
                />
                {{ feature }}
            </li>
        </ul>

        <p
            class="mt-6 mb-8 rounded-2xl bg-surface-muted px-4 py-3 text-sm text-foreground-muted"
        >
            <span class="font-medium text-foreground">{{
                t('packages.ideal_for')
            }}</span>
            {{ t(`packages.items.${key}.ideal`) }}
        </p>

        <p
            class="mt-auto border-t border-border pt-6 font-display text-xl font-medium text-foreground"
        >
            {{ t('packages.price') }}
        </p>
    </article>
</template>
