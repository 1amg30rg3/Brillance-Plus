<script setup lang="ts">
import ContactAside from '@/components/contact/ContactAside.vue';
import InquiryForm from '@/components/contact/InquiryForm.vue';
import PageHero from '@/components/sections/PageHero.vue';
import { useI18n } from '@/composables/useI18n';
import type { InquiryOptions, InquiryPrefill } from '@/types';

const props = defineProps<{
    options: InquiryOptions;
    prefill: InquiryPrefill;
    formToken: string;
}>();

const { t } = useI18n();
</script>

<template>
    <div>
        <PageHero
            :eyebrow="t('contact.page.eyebrow')"
            :title="t('contact.page.title')"
            :intro="t('contact.page.intro')"
        />

        <section
            id="devis"
            class="scroll-mt-20 bg-background-muted pb-20 sm:pb-24 lg:pb-28"
        >
            <div
                class="container-site grid items-start gap-8 lg:grid-cols-12 lg:gap-10"
            >
                <div class="lg:col-span-8">
                    <InquiryForm
                        :options="props.options"
                        :prefill="props.prefill"
                        :form-token="props.formToken"
                    />
                </div>
                <div class="lg:col-span-4">
                    <ContactAside />
                </div>
            </div>
        </section>
    </div>
</template>
