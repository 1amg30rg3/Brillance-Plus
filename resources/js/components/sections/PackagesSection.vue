<script setup lang="ts">
import { Info } from '@lucide/vue';
import PackageCard from '@/components/sections/PackageCard.vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import { useI18n } from '@/composables/useI18n';
import { packages, recommendedPackage } from '@/lib/services';

const { t } = useI18n();
</script>

<template>
    <section class="py-20 sm:py-24 lg:py-28" aria-labelledby="packages-title">
        <div class="container-site">
            <SectionHeading
                id="packages-title"
                :eyebrow="t('packages.eyebrow')"
                :title="t('packages.title')"
                :subtitle="t('packages.subtitle')"
            />

            <div
                class="mx-auto mt-16 grid max-w-6xl items-stretch gap-8 lg:grid-cols-3 lg:gap-6"
            >
                <div
                    v-for="(item, index) in packages"
                    :key="item"
                    v-reveal="index * 100"
                >
                    <PackageCard
                        :package="item"
                        :recommended="item === recommendedPackage"
                    />
                </div>
            </div>

            <p
                v-reveal
                class="mx-auto mt-12 flex max-w-3xl items-start gap-3 text-sm leading-relaxed text-foreground-muted"
            >
                <Info
                    class="mt-0.5 size-4 shrink-0 text-accent-strong"
                    aria-hidden="true"
                />
                {{ t('packages.note') }}
            </p>
        </div>
    </section>
</template>
