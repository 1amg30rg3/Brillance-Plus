<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Wallet } from '@lucide/vue';
import SparkleMark from '@/components/brand/SparkleMark.vue';
import ContactChannelLinks from '@/components/contact/ContactChannelLinks.vue';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { buttonClasses } from '@/lib/button';

const { t } = useI18n();
const { quoteUrl } = useSiteRoutes();
</script>

<template>
    <section class="pb-20 sm:pb-24 lg:pb-28" aria-labelledby="cta-title">
        <div class="container-site">
            <div
                v-reveal
                class="relative isolate overflow-hidden rounded-[2.5rem] bg-linear-to-br from-brand-deep via-[#0c3558] to-brand-navy px-6 py-16 text-center text-white shadow-2xl shadow-sky-900/20 sm:px-12 lg:py-20"
            >
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0 -z-10"
                >
                    <div
                        class="absolute -top-24 left-1/2 h-72 w-[40rem] -translate-x-1/2 rounded-full bg-sky-400/30 blur-3xl"
                    />
                    <SparkleMark
                        class="absolute top-10 left-[10%] size-6 text-sky-300/70 motion-safe:animate-twinkle"
                    />
                    <SparkleMark
                        class="absolute right-[12%] bottom-12 size-8 text-sky-200/60 motion-safe:animate-twinkle motion-safe:[animation-delay:1.8s]"
                    />
                    <SparkleMark
                        class="absolute top-1/2 right-[6%] size-3 text-white/60 motion-safe:animate-twinkle motion-safe:[animation-delay:0.9s]"
                    />
                </div>

                <h2
                    id="cta-title"
                    class="mx-auto max-w-2xl font-display text-3xl font-medium tracking-tight sm:text-4xl lg:text-5xl"
                >
                    {{ t('common.cta_band.title') }}
                </h2>
                <p
                    class="mx-auto mt-5 max-w-xl text-base leading-relaxed text-slate-300 sm:text-lg"
                >
                    {{ t('common.cta_band.text') }}
                </p>

                <Link
                    :href="quoteUrl()"
                    :class="buttonClasses('light', 'lg', 'group mt-10')"
                >
                    {{ t('common.cta.quote') }}
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-0.5"
                        aria-hidden="true"
                    />
                </Link>

                <div class="mt-8 flex flex-col items-center gap-3">
                    <p class="text-sm text-slate-300">
                        {{ t('common.messaging.or_contact_us') }}
                    </p>
                    <ContactChannelLinks inverse align="center" />
                </div>

                <p
                    class="mt-8 inline-flex items-center gap-2 text-sm text-sky-200"
                >
                    <Wallet class="size-4" aria-hidden="true" />
                    {{ t('common.payment_on_site') }}
                </p>
            </div>
        </div>
    </section>
</template>
