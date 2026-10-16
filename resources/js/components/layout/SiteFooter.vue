<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowUpRight, Mail, Phone, Wallet } from '@lucide/vue';
import { computed } from 'vue';
import AppLogo from '@/components/brand/AppLogo.vue';
import MessengerIcon from '@/components/brand/MessengerIcon.vue';
import WhatsAppIcon from '@/components/brand/WhatsAppIcon.vue';
import LanguageSwitcher from '@/components/layout/LanguageSwitcher.vue';
import ThemeSwitcher from '@/components/layout/ThemeSwitcher.vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { services } from '@/lib/services';
import type { SitePageName } from '@/types';

const { t } = useI18n();
const { pageUrl, isCurrent } = useSiteRoutes();
const { business, phoneHref, emailHref, whatsappUrl, messengerUrl } =
    useBusiness();

const year = new Date().getFullYear();

const page = usePage();
const agency = computed(() => page.props.agency);

/** Credit link to the agency that built the website, tagged so referrals can be measured. */
const creditUrl = computed(() => {
    const url = new URL(agency.value.url);
    url.search = new URLSearchParams({
        utm_source: 'brillance-plus.fr',
        utm_medium: 'referral',
        utm_campaign: 'site-credit',
    }).toString();

    return url.toString();
});

const navigation = computed<{ name: SitePageName; label: string }[]>(() =>
    (
        [
            'home',
            'services',
            'pricing',
            'how_it_works',
            'about',
            'contact',
        ] as const
    ).map((name) => ({ name, label: t(`nav.${name}`) })),
);

const legalLinks = computed<{ name: SitePageName; label: string }[]>(() =>
    (['legal_notice', 'privacy_policy', 'terms'] as const).map((name) => ({
        name,
        label: t(`nav.${name}`),
    })),
);

const linkClasses =
    'rounded text-sm text-slate-300 transition-colors hover:text-white';
</script>

<template>
    <!-- The footer keeps the same dark navy palette in both themes. -->
    <footer
        class="relative overflow-hidden border-t border-white/5 bg-brand-navy text-slate-300"
    >
        <div
            aria-hidden="true"
            class="pointer-events-none absolute -top-40 left-1/2 h-80 w-[48rem] -translate-x-1/2 rounded-full bg-sky-500/10 blur-3xl"
        />

        <div
            class="relative container-site pt-16 lg:pb-12"
            :class="isCurrent('contact') ? 'pb-12' : 'pb-28'"
        >
            <div class="grid gap-12 lg:grid-cols-12">
                <div class="flex flex-col gap-5 lg:col-span-4">
                    <Link
                        :href="pageUrl('home')"
                        class="self-start rounded-xl"
                        :aria-label="t('common.home_link')"
                    >
                        <AppLogo inverse />
                    </Link>
                    <p class="max-w-sm text-sm leading-relaxed">
                        {{ t('footer.description') }}
                    </p>
                    <p
                        class="inline-flex items-center gap-2 self-start rounded-full border border-white/10 bg-white/5 px-3.5 py-1.5 text-xs font-medium text-sky-200"
                    >
                        <Wallet class="size-3.5" aria-hidden="true" />
                        {{ t('common.payment_on_site') }}
                    </p>
                </div>

                <nav class="lg:col-span-2" :aria-label="t('footer.navigation')">
                    <h2 class="text-sm font-semibold text-white">
                        {{ t('footer.navigation') }}
                    </h2>
                    <ul class="mt-4 flex flex-col gap-3">
                        <li v-for="item in navigation" :key="item.name">
                            <Link
                                :href="pageUrl(item.name)"
                                :class="linkClasses"
                                >{{ item.label }}</Link
                            >
                        </li>
                    </ul>
                </nav>

                <nav class="lg:col-span-3" :aria-label="t('footer.services')">
                    <h2 class="text-sm font-semibold text-white">
                        {{ t('footer.services') }}
                    </h2>
                    <ul class="mt-4 flex flex-col gap-3">
                        <li v-for="service in services" :key="service.key">
                            <Link
                                :href="`${pageUrl('services')}#service-${service.key}`"
                                :class="linkClasses"
                            >
                                {{ t(`services.items.${service.key}.title`) }}
                            </Link>
                        </li>
                    </ul>
                </nav>

                <div class="lg:col-span-3">
                    <h2 class="text-sm font-semibold text-white">
                        {{ t('footer.contact') }}
                    </h2>
                    <ul class="mt-4 flex flex-col gap-3 text-sm">
                        <li>
                            <a
                                :href="phoneHref"
                                class="inline-flex items-center gap-2.5 rounded font-medium text-white transition-colors hover:text-sky-300"
                            >
                                <Phone
                                    class="size-4 text-sky-300"
                                    aria-hidden="true"
                                />
                                <span class="sr-only"
                                    >{{ t('common.contact.phone') }} :</span
                                >
                                {{ business.phoneDisplay }}
                            </a>
                        </li>
                        <li v-if="whatsappUrl">
                            <a
                                :href="whatsappUrl"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2.5 rounded text-white transition-colors hover:text-sky-300"
                            >
                                <WhatsAppIcon class="size-4 text-[#25D366]" />
                                {{ t('common.messaging.whatsapp') }}
                                <span class="sr-only">{{
                                    t('common.messaging.new_tab')
                                }}</span>
                            </a>
                        </li>
                        <li v-if="messengerUrl">
                            <a
                                :href="messengerUrl"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2.5 rounded text-white transition-colors hover:text-sky-300"
                            >
                                <MessengerIcon class="size-4 text-[#4FA3FF]" />
                                {{ t('common.messaging.messenger') }}
                                <span class="sr-only">{{
                                    t('common.messaging.new_tab')
                                }}</span>
                            </a>
                        </li>
                        <li v-if="business.email && emailHref">
                            <a
                                :href="emailHref"
                                class="inline-flex items-center gap-2.5 rounded break-all text-white transition-colors hover:text-sky-300"
                            >
                                <Mail
                                    class="size-4 shrink-0 text-sky-300"
                                    aria-hidden="true"
                                />
                                <span class="sr-only"
                                    >{{ t('common.contact.email') }} :</span
                                >
                                {{ business.email }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="mt-14 flex flex-col gap-6 border-t border-white/10 pt-8 lg:flex-row lg:items-center lg:justify-between"
            >
                <div
                    class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6"
                >
                    <p class="text-xs text-slate-400">
                        {{ t('footer.rights', { year }) }}
                    </p>
                    <nav :aria-label="t('footer.legal')">
                        <ul class="flex flex-wrap gap-x-5 gap-y-2">
                            <li v-for="item in legalLinks" :key="item.name">
                                <Link
                                    :href="pageUrl(item.name)"
                                    class="rounded text-xs text-slate-400 transition-colors hover:text-white"
                                >
                                    {{ item.label }}
                                </Link>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div
                    class="flex flex-wrap items-center gap-3"
                    role="group"
                    :aria-label="t('footer.preferences')"
                >
                    <LanguageSwitcher inverse />
                    <ThemeSwitcher inverse />
                </div>
            </div>

            <!-- The whole card is clickable: the link below stretches over it (after:absolute after:inset-0). -->
            <div
                class="group relative mt-8 flex flex-col gap-4 rounded-2xl border border-white/10 bg-white/[0.03] p-5 transition duration-300 hover:border-[#ff6a5b]/40 hover:bg-white/[0.06] has-[a:focus-visible]:outline-2 has-[a:focus-visible]:outline-offset-4 has-[a:focus-visible]:outline-ring sm:flex-row sm:items-center sm:justify-between"
            >
                <div class="flex items-center gap-4">
                    <!-- Decorative: the agency name is written right next to it. -->
                    <img
                        src="/images/websavvys-logo.png"
                        alt=""
                        width="40"
                        height="40"
                        loading="lazy"
                        decoding="async"
                        class="size-10 shrink-0 rounded-full shadow-lg shadow-[#ff6a5b]/20 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-6"
                    />
                    <p class="text-sm text-slate-300">
                        {{ t('footer.credit.label') }}
                        <span class="font-semibold text-white">{{
                            agency.name
                        }}</span>
                        <span class="mt-1 block text-xs text-slate-400">
                            {{ t('footer.credit.pitch') }}
                        </span>
                    </p>
                </div>
                <a
                    :href="creditUrl"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex min-h-10 shrink-0 items-center gap-1.5 self-start rounded-full border border-white/20 px-4 text-sm font-medium text-white transition group-hover:border-sky-300/60 group-hover:bg-white/10 after:absolute after:inset-0 after:rounded-2xl after:content-[''] focus-visible:outline-none sm:self-auto"
                >
                    {{ t('footer.credit.cta') }}
                    <ArrowUpRight
                        class="size-4 text-sky-300 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                        aria-hidden="true"
                    />
                    <span class="sr-only">{{
                        t('common.messaging.new_tab')
                    }}</span>
                </a>
            </div>
        </div>
    </footer>
</template>
