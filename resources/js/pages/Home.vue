<script setup lang="ts">
import AboutTeaser from '@/components/sections/AboutTeaser.vue';
import CtaSection from '@/components/sections/CtaSection.vue';
import FaqSection from '@/components/sections/FaqSection.vue';
import HomeHero from '@/components/sections/HomeHero.vue';
import PackagesSection from '@/components/sections/PackagesSection.vue';
import PricingSection from '@/components/sections/PricingSection.vue';
import ProcessSection from '@/components/sections/ProcessSection.vue';
import ServicesSection from '@/components/sections/ServicesSection.vue';
import TrustSection from '@/components/sections/TrustSection.vue';
</script>

<template>
    <div>
        <HomeHero />
        <TrustSection />
        <ServicesSection show-all-link />
        <PricingSection show-details-link />
        <PackagesSection />
        <AboutTeaser />
        <ProcessSection />
        <FaqSection class="border-t border-border/60" />
        <CtaSection />
    </div>
</template>
