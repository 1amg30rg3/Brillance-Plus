<script setup lang="ts">
import CtaSection from '@/components/sections/CtaSection.vue';
import PackagesSection from '@/components/sections/PackagesSection.vue';
import PageHero from '@/components/sections/PageHero.vue';
import ServicesSection from '@/components/sections/ServicesSection.vue';
import { useI18n } from '@/composables/useI18n';

const { t } = useI18n();
</script>

<template>
    <div>
        <PageHero
            :eyebrow="t('services.page.eyebrow')"
            :title="t('services.page.title')"
            :intro="t('services.page.intro')"
        />
        <ServicesSection detailed :show-heading="false" />
        <PackagesSection class="bg-background-muted" />
        <CtaSection class="pt-20 sm:pt-24 lg:pt-28" />
    </div>
</template>
