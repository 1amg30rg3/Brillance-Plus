<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Building, Check, House } from '@lucide/vue';
import { computed } from 'vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { buttonClasses } from '@/lib/button';
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        plan: 'apartment' | 'house';
        featured?: boolean;
    }>(),
    { featured: false },
);

const { t, tm } = useI18n();
const { quoteUrl } = useSiteRoutes();
const { formattedHourlyPriceFrom } = useBusiness();

const price = computed(() => formattedHourlyPriceFrom(props.plan));
const highlights = computed(() =>
    tm<string[]>(`pricing.plans.${props.plan}.highlights`),
);
const icon = computed(() => (props.plan === 'house' ? House : Building));
</script>

<template>
    <article
        :class="
            cn(
                'group relative flex h-full flex-col overflow-hidden rounded-[2rem] border p-8 transition duration-300 ease-out hover:-translate-y-1 sm:p-10',
                props.featured
                    ? 'border-sky-400/30 bg-linear-to-br from-brand-deep via-[#0d3a63] to-brand-navy text-white shadow-2xl shadow-sky-900/25'
                    : 'border-border bg-surface shadow-xl shadow-sky-900/5 hover:border-accent/40 dark:shadow-black/30',
            )
        "
    >
        <div
            v-if="props.featured"
            aria-hidden="true"
            class="pointer-events-none absolute -top-24 -right-24 size-64 rounded-full bg-sky-400/25 blur-3xl"
        />

        <div class="relative flex items-center gap-4">
            <span
                :class="
                    cn(
                        'grid size-12 place-items-center rounded-2xl',
                        props.featured
                            ? 'bg-white/10 text-sky-300'
                            : 'bg-accent-soft text-accent-strong',
                    )
                "
            >
                <component :is="icon" class="size-6" aria-hidden="true" />
            </span>
            <h3 class="font-display text-2xl font-medium">
                {{ t(`pricing.plans.${props.plan}.label`) }}
            </h3>
        </div>

        <p
            :class="
                cn(
                    'relative mt-4 text-sm leading-relaxed',
                    props.featured ? 'text-slate-300' : 'text-foreground-muted',
                )
            "
        >
            {{ t(`pricing.plans.${props.plan}.description`) }}
        </p>

        <div class="relative mt-8">
            <p
                :class="
                    cn(
                        'text-sm font-medium',
                        props.featured ? 'text-sky-200' : 'text-accent-strong',
                    )
                "
            >
                {{ t('common.price.from') }}
            </p>
            <p class="mt-1 flex items-baseline gap-1">
                <span
                    class="font-display text-6xl font-medium tracking-tight"
                    >{{ price }}</span
                >
                <span
                    :class="
                        cn(
                            'text-lg',
                            props.featured
                                ? 'text-slate-300'
                                : 'text-foreground-muted',
                        )
                    "
                >
                    {{ t('common.price.per_hour') }}
                </span>
            </p>
            <p
                :class="
                    cn(
                        'mt-2 text-xs',
                        props.featured
                            ? 'text-slate-400'
                            : 'text-foreground-muted',
                    )
                "
            >
                {{ t('pricing.starting_price') }}
            </p>
        </div>

        <ul
            class="relative mt-8 flex flex-col gap-3 border-t pt-8"
            :class="props.featured ? 'border-white/10' : 'border-border'"
        >
            <li
                v-for="highlight in highlights"
                :key="highlight"
                class="flex items-start gap-3 text-sm"
            >
                <span
                    :class="
                        cn(
                            'mt-0.5 grid size-5 shrink-0 place-items-center rounded-full',
                            props.featured
                                ? 'bg-sky-400/20 text-sky-300'
                                : 'bg-accent-soft text-accent-strong',
                        )
                    "
                >
                    <Check class="size-3" aria-hidden="true" />
                </span>
                {{ highlight }}
            </li>
        </ul>

        <div class="relative mt-auto pt-10">
            <Link
                :href="quoteUrl({ service: props.plan })"
                :class="
                    buttonClasses(
                        props.featured ? 'light' : 'primary',
                        'lg',
                        'group/button w-full',
                    )
                "
            >
                {{ t('common.cta.quote') }}
                <ArrowRight
                    class="size-4 transition-transform group-hover/button:translate-x-0.5"
                    aria-hidden="true"
                />
            </Link>
        </div>
    </article>
</template>
