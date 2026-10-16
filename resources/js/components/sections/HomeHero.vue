<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Phone, Wallet } from '@lucide/vue';
import { computed } from 'vue';
import SparkleMark from '@/components/brand/SparkleMark.vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { buttonClasses } from '@/lib/button';
import { imageSrcset } from '@/lib/services';
import type { ServiceKey } from '@/types';

const { t } = useI18n();
const { pageUrl, quoteUrl } = useSiteRoutes();
const { business, phoneHref, formattedHourlyPriceFrom } = useBusiness();

const titleParts = computed(() => t('home.hero.title').split(':highlight'));

const prices = computed(() =>
    (['apartment', 'house'] as ServiceKey[]).map((service) => ({
        service,
        label: t(`enums.property_type.${service}`),
        price: formattedHourlyPriceFrom(service),
    })),
);
</script>

<template>
    <section
        class="relative isolate overflow-hidden"
        aria-labelledby="hero-title"
    >
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-0 -z-10"
        >
            <div
                class="absolute -top-40 right-[-15%] h-[34rem] w-[34rem] rounded-full bg-sky-300/30 blur-3xl motion-safe:animate-fade-in dark:bg-sky-500/15"
            />
            <div
                class="absolute top-1/3 left-[-20%] h-[28rem] w-[28rem] rounded-full bg-blue-200/40 blur-3xl dark:bg-blue-800/20"
            />
            <div
                class="absolute inset-0 [background-image:radial-gradient(var(--border-strong)_1px,transparent_1px)] [mask-image:radial-gradient(ellipse_at_top,black,transparent_70%)] [background-size:28px_28px] opacity-[0.35] dark:opacity-25"
            />
        </div>

        <div
            class="container-site grid items-center gap-12 pt-6 pb-16 sm:pt-10 lg:grid-cols-12 lg:gap-14 lg:pt-14 lg:pb-24"
        >
            <div class="lg:col-span-6">
                <p
                    class="inline-flex items-center gap-2 rounded-full border border-border bg-surface/70 px-3.5 py-1.5 text-xs font-medium text-foreground-muted backdrop-blur motion-safe:animate-fade-up"
                >
                    <span class="relative flex size-2">
                        <span
                            class="absolute inline-flex size-full rounded-full bg-accent opacity-60 motion-safe:animate-ping"
                        />
                        <span
                            class="relative inline-flex size-2 rounded-full bg-accent"
                        />
                    </span>
                    {{ t('home.hero.eyebrow') }}
                </p>

                <h1
                    id="hero-title"
                    class="mt-6 font-display text-[2.6rem] leading-[1.04] font-medium tracking-tight text-foreground motion-safe:animate-fade-up motion-safe:[animation-delay:80ms] sm:text-6xl lg:text-[4.1rem]"
                >
                    {{ titleParts[0]
                    }}<em class="text-highlight pr-1 font-medium italic">{{
                        t('home.hero.highlight')
                    }}</em
                    >{{ titleParts[1] }}
                </h1>

                <p
                    class="mt-6 max-w-xl text-lg leading-relaxed text-foreground-muted motion-safe:animate-fade-up motion-safe:[animation-delay:160ms]"
                >
                    {{ t('home.hero.subtitle') }}
                </p>

                <div
                    class="mt-9 flex flex-col gap-3 motion-safe:animate-fade-up motion-safe:[animation-delay:240ms] sm:flex-row"
                >
                    <Link
                        :href="quoteUrl()"
                        :class="buttonClasses('primary', 'lg', 'group')"
                    >
                        {{ t('common.cta.quote') }}
                        <ArrowRight
                            class="size-4 transition-transform group-hover:translate-x-0.5"
                            aria-hidden="true"
                        />
                    </Link>
                    <a
                        :href="phoneHref"
                        :class="buttonClasses('secondary', 'lg')"
                    >
                        <Phone class="size-4" aria-hidden="true" />
                        {{ t('common.cta.call') }}
                    </a>
                </div>

                <div
                    class="mt-8 flex flex-col gap-4 motion-safe:animate-fade-up motion-safe:[animation-delay:320ms] sm:flex-row sm:items-center sm:gap-8"
                >
                    <p class="text-sm text-foreground-muted">
                        {{ t('home.hero.call_label') }}<br />
                        <a
                            :href="phoneHref"
                            class="font-display text-2xl font-medium text-foreground transition-colors hover:text-accent-strong"
                        >
                            {{ business.phoneDisplay }}
                        </a>
                    </p>
                    <p
                        class="inline-flex items-center gap-2.5 text-sm font-medium text-foreground sm:border-l sm:border-border sm:pl-8"
                    >
                        <span
                            class="grid size-9 place-items-center rounded-full bg-accent-soft text-accent-strong"
                        >
                            <Wallet class="size-4" aria-hidden="true" />
                        </span>
                        {{ t('common.payment_on_site') }}
                    </p>
                </div>
            </div>

            <div
                class="relative motion-safe:animate-fade-up motion-safe:[animation-delay:200ms] lg:col-span-6"
            >
                <SparkleMark
                    aria-hidden="true"
                    class="absolute -top-5 -left-3 z-10 size-8 text-accent motion-safe:animate-twinkle"
                />
                <SparkleMark
                    aria-hidden="true"
                    class="absolute -right-2 bottom-1/3 z-10 hidden size-4 text-accent/70 motion-safe:animate-twinkle motion-safe:[animation-delay:2s] lg:block"
                />

                <div
                    class="relative overflow-hidden rounded-[2rem] border border-border/60 bg-surface-muted shadow-2xl shadow-sky-900/10 dark:shadow-black/40"
                >
                    <img
                        :srcset="
                            imageSrcset('hero-living-room', [640, 960, 1280])
                        "
                        sizes="(min-width: 1024px) 46vw, 100vw"
                        src="/images/hero-living-room-960.webp"
                        width="960"
                        height="1200"
                        :alt="t('home.hero.image_alt')"
                        fetchpriority="high"
                        decoding="async"
                        class="aspect-[4/3] w-full object-cover sm:aspect-[16/11] lg:aspect-[4/5]"
                    />
                    <div
                        aria-hidden="true"
                        class="absolute inset-0 bg-linear-to-t from-brand-navy/25 via-transparent to-transparent"
                    />

                    <div
                        class="absolute top-5 right-5 hidden items-center gap-3 rounded-2xl border border-white/40 bg-white/85 px-4 py-3 shadow-lg backdrop-blur-md sm:flex dark:border-white/10 dark:bg-brand-navy/80"
                    >
                        <span
                            class="grid size-9 place-items-center rounded-full bg-accent-soft text-accent-strong"
                        >
                            <Wallet class="size-4" aria-hidden="true" />
                        </span>
                        <span class="text-sm leading-tight">
                            <span
                                class="block font-semibold text-brand-navy dark:text-white"
                                >{{ t('home.hero.payment_title') }}</span
                            >
                            <span class="text-slate-600 dark:text-slate-300">{{
                                t('home.hero.payment_text')
                            }}</span>
                        </span>
                    </div>
                </div>

                <div
                    class="relative z-10 mx-3 -mt-16 rounded-3xl border border-border bg-surface/95 p-5 shadow-xl shadow-sky-900/10 backdrop-blur-md sm:mx-8 lg:absolute lg:-bottom-10 lg:-left-10 lg:mx-0 lg:mt-0 lg:w-80 motion-safe:lg:animate-float dark:shadow-black/40"
                >
                    <p
                        class="text-xs font-semibold tracking-[0.16em] text-accent-strong uppercase"
                    >
                        {{ t('home.hero.prices_title') }}
                    </p>
                    <dl class="mt-3 divide-y divide-border">
                        <div
                            v-for="item in prices"
                            :key="item.service"
                            class="flex items-baseline justify-between gap-4 py-2.5"
                        >
                            <dt class="text-sm font-medium text-foreground">
                                {{ item.label }}
                            </dt>
                            <dd
                                class="text-right text-sm text-foreground-muted"
                            >
                                {{ t('common.price.from') }}
                                <span
                                    class="font-display text-xl font-medium text-foreground"
                                    >{{ item.price }}</span
                                >{{ t('common.price.per_hour') }}
                            </dd>
                        </div>
                    </dl>
                    <Link
                        :href="pageUrl('pricing')"
                        class="mt-2 inline-flex items-center gap-1.5 rounded text-sm font-medium text-accent-strong hover:underline"
                    >
                        {{ t('common.cta.see_pricing') }}
                        <ArrowRight class="size-3.5" aria-hidden="true" />
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
