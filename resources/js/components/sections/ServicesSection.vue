<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Info } from '@lucide/vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import ServiceCard from '@/components/sections/ServiceCard.vue';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { buttonClasses } from '@/lib/button';
import { services } from '@/lib/services';

withDefaults(
    defineProps<{
        detailed?: boolean;
        showHeading?: boolean;
        showAllLink?: boolean;
    }>(),
    { detailed: false, showHeading: true, showAllLink: false },
);

const { t } = useI18n();
const { pageUrl } = useSiteRoutes();
</script>

<template>
    <section class="py-20 sm:py-24 lg:py-28" aria-labelledby="services-title">
        <div class="container-site">
            <SectionHeading
                v-if="showHeading"
                id="services-title"
                :eyebrow="t('services.eyebrow')"
                :title="t('services.title')"
                :subtitle="t('services.subtitle')"
            />
            <h2 v-else id="services-title" class="sr-only">
                {{ t('services.eyebrow') }}
            </h2>

            <div
                :class="[
                    'grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3',
                    showHeading && 'mt-14 lg:mt-16',
                ]"
            >
                <div
                    v-for="(service, index) in services"
                    :key="service.key"
                    v-reveal="(index % 3) * 90"
                    class="flex"
                >
                    <ServiceCard
                        :service="service"
                        :detailed="detailed"
                        class="w-full"
                    />
                </div>
            </div>

            <p
                v-reveal
                class="mx-auto mt-12 flex max-w-3xl items-start gap-3 rounded-2xl border border-border bg-surface-muted p-5 text-sm leading-relaxed text-foreground-muted"
            >
                <Info
                    class="mt-0.5 size-4 shrink-0 text-accent-strong"
                    aria-hidden="true"
                />
                {{ t('services.pricing_note') }}
            </p>

            <div v-if="showAllLink" class="mt-10 text-center">
                <Link
                    :href="pageUrl('services')"
                    :class="buttonClasses('secondary', 'md', 'group')"
                >
                    {{ t('services.see_all') }}
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-0.5"
                        aria-hidden="true"
                    />
                </Link>
            </div>
        </div>
    </section>
</template>
