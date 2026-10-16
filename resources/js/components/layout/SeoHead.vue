<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { SeoMetadata } from '@/types';

const page = usePage();

const seo = computed(() => page.props.seo as SeoMetadata | undefined);
</script>

<template>
    <!-- head-key values match the data-inertia attributes of resources/views/partials/seo.blade.php -->
    <Head v-if="seo" :title="seo.title">
        <meta
            head-key="description"
            name="description"
            :content="seo.description"
        />
        <link head-key="canonical" rel="canonical" :href="seo.canonical" />
        <link
            v-for="(url, hreflang) in seo.alternates"
            :key="hreflang"
            :head-key="`alternate-${hreflang}`"
            rel="alternate"
            :hreflang="hreflang"
            :href="url"
        />
        <link
            head-key="alternate-x-default"
            rel="alternate"
            hreflang="x-default"
            :href="seo.defaultAlternate"
        />
        <meta head-key="og:type" property="og:type" content="website" />
        <meta
            head-key="og:site_name"
            property="og:site_name"
            :content="seo.siteName"
        />
        <meta head-key="og:title" property="og:title" :content="seo.title" />
        <meta
            head-key="og:description"
            property="og:description"
            :content="seo.description"
        />
        <meta head-key="og:url" property="og:url" :content="seo.canonical" />
        <meta head-key="og:image" property="og:image" :content="seo.image" />
        <meta
            head-key="og:image:width"
            property="og:image:width"
            content="1200"
        />
        <meta
            head-key="og:image:height"
            property="og:image:height"
            content="630"
        />
        <meta
            head-key="og:locale"
            property="og:locale"
            :content="seo.openGraphLocale"
        />
        <meta
            v-for="alternateLocale in seo.openGraphAlternateLocales"
            :key="alternateLocale"
            :head-key="`og:locale:alternate-${alternateLocale}`"
            property="og:locale:alternate"
            :content="alternateLocale"
        />
        <meta
            head-key="twitter:card"
            name="twitter:card"
            content="summary_large_image"
        />
    </Head>
</template>
