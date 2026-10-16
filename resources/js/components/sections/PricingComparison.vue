<script setup lang="ts">
import { Building, House } from '@lucide/vue';
import { computed } from 'vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';

const { t } = useI18n();
const { formattedHourlyPriceFrom } = useBusiness();

const plans = ['apartment', 'house'] as const;
const criteria = [
    'price',
    'property',
    'scope',
    'frequency',
    'payment',
] as const;

type Criterion = (typeof criteria)[number];

const planLabels = computed(() => ({
    apartment: t('pricing.plans.apartment.label'),
    house: t('pricing.plans.house.label'),
}));

function value(plan: (typeof plans)[number], criterion: Criterion): string {
    if (criterion === 'price') {
        return t('common.price.from_per_hour', {
            price: formattedHourlyPriceFrom(plan) ?? '',
        });
    }

    return t(`pricing.comparison.${plan}.${criterion}`);
}
</script>

<template>
    <section class="py-20 sm:py-24 lg:py-28" aria-labelledby="comparison-title">
        <div class="container-site">
            <SectionHeading
                id="comparison-title"
                :eyebrow="t('pricing.comparison.eyebrow')"
                :title="t('pricing.comparison.title')"
                :subtitle="t('pricing.comparison.subtitle')"
            />

            <div
                v-reveal
                class="mx-auto mt-12 hidden max-w-5xl overflow-hidden rounded-3xl border border-border bg-surface sm:block"
            >
                <table class="w-full table-fixed text-left text-sm">
                    <caption class="sr-only">
                        {{
                            t('pricing.comparison.caption')
                        }}
                    </caption>
                    <thead class="bg-surface-muted">
                        <tr>
                            <th
                                scope="col"
                                class="w-1/4 px-6 py-5 font-medium text-foreground-muted"
                            >
                                {{ t('pricing.comparison.criterion') }}
                            </th>
                            <th
                                v-for="plan in plans"
                                :key="plan"
                                scope="col"
                                class="px-6 py-5"
                            >
                                <span
                                    class="inline-flex items-center gap-2.5 font-display text-lg font-medium text-foreground"
                                >
                                    <component
                                        :is="
                                            plan === 'house' ? House : Building
                                        "
                                        class="size-5 text-accent-strong"
                                        aria-hidden="true"
                                    />
                                    {{ planLabels[plan] }}
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        <tr
                            v-for="criterion in criteria"
                            :key="criterion"
                            class="transition-colors hover:bg-surface-muted/60"
                        >
                            <th
                                scope="row"
                                class="px-6 py-5 font-medium text-foreground"
                            >
                                {{ t(`pricing.comparison.rows.${criterion}`) }}
                            </th>
                            <td
                                v-for="plan in plans"
                                :key="plan"
                                class="px-6 py-5"
                                :class="
                                    criterion === 'price'
                                        ? 'font-display text-lg text-accent-strong'
                                        : 'text-foreground-muted'
                                "
                            >
                                {{ value(plan, criterion) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-10 grid gap-4 sm:hidden">
                <div
                    v-for="plan in plans"
                    :key="plan"
                    class="rounded-3xl border border-border bg-surface p-6"
                >
                    <h3
                        class="flex items-center gap-2.5 font-display text-lg font-medium text-foreground"
                    >
                        <component
                            :is="plan === 'house' ? House : Building"
                            class="size-5 text-accent-strong"
                            aria-hidden="true"
                        />
                        {{ planLabels[plan] }}
                    </h3>
                    <dl class="mt-4 divide-y divide-border text-sm">
                        <div
                            v-for="criterion in criteria"
                            :key="criterion"
                            class="flex flex-col gap-1 py-3"
                        >
                            <dt
                                class="text-xs font-medium tracking-wide text-foreground-muted uppercase"
                            >
                                {{ t(`pricing.comparison.rows.${criterion}`) }}
                            </dt>
                            <dd
                                :class="
                                    criterion === 'price'
                                        ? 'font-display text-lg text-accent-strong'
                                        : 'text-foreground'
                                "
                            >
                                {{ value(plan, criterion) }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </section>
</template>
