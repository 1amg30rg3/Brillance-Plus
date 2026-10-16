<script setup lang="ts">
import CtaSection from '@/components/sections/CtaSection.vue';
import FaqSection from '@/components/sections/FaqSection.vue';
import PackagesSection from '@/components/sections/PackagesSection.vue';
import PageHero from '@/components/sections/PageHero.vue';
import PricingComparison from '@/components/sections/PricingComparison.vue';
import PricingSection from '@/components/sections/PricingSection.vue';
import { useI18n } from '@/composables/useI18n';

const { t } = useI18n();
</script>

<template>
    <div>
        <PageHero
            :eyebrow="t('pricing.page.eyebrow')"
            :title="t('pricing.page.title')"
            :intro="t('pricing.page.intro')"
        />
        <PricingSection :show-heading="false" class="pt-4 sm:pt-8 lg:pt-10" />
        <PricingComparison />
        <PackagesSection class="bg-background-muted" />
        <FaqSection />
        <CtaSection />
    </div>
</template>
