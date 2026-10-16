<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Check } from '@lucide/vue';
import { computed } from 'vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { imageSrcset } from '@/lib/services';
import type { ServiceVisual } from '@/lib/services';

const props = withDefaults(
    defineProps<{
        service: ServiceVisual;
        detailed?: boolean;
    }>(),
    { detailed: false },
);

const { t, tm } = useI18n();
const { pageUrl } = useSiteRoutes();
const { formattedHourlyPriceFrom } = useBusiness();

const key = computed(() => props.service.key);
const price = computed(() => formattedHourlyPriceFrom(key.value));
const features = computed(() =>
    tm<string[]>(`services.items.${key.value}.features`),
);
</script>

<template>
    <article
        :id="`service-${key}`"
        class="group relative flex scroll-mt-28 flex-col overflow-hidden rounded-3xl border border-border bg-surface transition duration-300 ease-out hover:-translate-y-1 hover:border-accent/40 hover:shadow-2xl hover:shadow-sky-900/10 dark:hover:shadow-black/40"
    >
        <div class="relative overflow-hidden">
            <img
                :srcset="imageSrcset(service.image, [480, 800])"
                sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, 100vw"
                :src="`/images/${service.image}-800.webp`"
                width="800"
                height="600"
                :alt="t(`services.items.${key}.image_alt`)"
                loading="lazy"
                decoding="async"
                class="aspect-[4/3] w-full object-cover transition duration-700 ease-out group-hover:scale-[1.04]"
            />
            <div
                aria-hidden="true"
                class="absolute inset-0 bg-linear-to-t from-brand-navy/35 via-transparent to-transparent"
            />
        </div>

        <div class="relative flex flex-1 flex-col p-6 sm:p-7">
            <span
                class="absolute -top-7 left-6 grid size-14 place-items-center rounded-2xl border border-border bg-surface text-accent-strong shadow-lg shadow-sky-900/10 transition-transform duration-300 group-hover:-rotate-6 sm:left-7"
            >
                <component
                    :is="service.icon"
                    class="size-6"
                    aria-hidden="true"
                />
            </span>

            <h3 class="mt-6 font-display text-xl font-medium text-foreground">
                {{ t(`services.items.${key}.title`) }}
            </h3>
            <p class="mt-2.5 text-sm leading-relaxed text-foreground-muted">
                {{ t(`services.items.${key}.description`) }}
            </p>

            <div v-if="detailed" class="mt-5">
                <p class="text-xs font-medium text-foreground-muted">
                    {{ t('services.may_include') }}
                </p>
                <ul class="mt-3 flex flex-col gap-2">
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
            </div>

            <div class="mt-auto pt-6">
                <div
                    class="flex items-end justify-between gap-4 border-t border-border pt-5"
                >
                    <p class="text-sm text-foreground-muted">
                        <template v-if="price">
                            {{ t('common.price.from') }}
                            <span
                                class="block font-display text-2xl font-medium text-foreground"
                            >
                                {{ price
                                }}<span
                                    class="font-sans text-sm text-foreground-muted"
                                    >{{ t('common.price.per_hour') }}</span
                                >
                            </span>
                        </template>
                        <span v-else class="font-medium text-foreground">{{
                            t('common.price.on_quote')
                        }}</span>
                    </p>
                    <Link
                        v-if="!detailed"
                        :href="`${pageUrl('services')}#service-${key}`"
                        class="inline-flex shrink-0 items-center gap-1.5 rounded-full py-2 text-sm font-medium text-accent-strong transition hover:gap-2.5"
                        :aria-label="`${t('common.cta.learn_more')} : ${t(`services.items.${key}.title`)}`"
                    >
                        {{ t('common.cta.learn_more') }}
                        <ArrowRight class="size-4" aria-hidden="true" />
                    </Link>
                </div>
            </div>
        </div>
    </article>
</template>
