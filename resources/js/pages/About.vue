<script setup lang="ts">
import {
    Eye,
    HandHeart,
    Euro,
    MessagesSquare,
    SlidersHorizontal,
    Wallet,
} from '@lucide/vue';
import { computed } from 'vue';
import SparkleMark from '@/components/brand/SparkleMark.vue';
import CtaSection from '@/components/sections/CtaSection.vue';
import PageHero from '@/components/sections/PageHero.vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';
import { imageSrcset } from '@/lib/services';
import type { TitledText } from '@/types';

const { t, tm } = useI18n();
const { formattedHourlyPriceFrom } = useBusiness();

const icons = [Eye, SlidersHorizontal, MessagesSquare, HandHeart, Euro, Wallet];

const paragraphs = computed(() => tm<string[]>('about.story.paragraphs'));

const values = computed(() =>
    tm<TitledText[]>('about.values.items').map((value) => ({
        title: value.title,
        text: value.text
            .replaceAll(
                ':apartment',
                formattedHourlyPriceFrom('apartment') ?? '',
            )
            .replaceAll(':house', formattedHourlyPriceFrom('house') ?? ''),
    })),
);
</script>

<template>
    <div>
        <PageHero
            :eyebrow="t('about.page.eyebrow')"
            :title="t('about.page.title')"
            :intro="t('about.page.intro')"
        />

        <section class="py-20 sm:py-24 lg:py-28" aria-labelledby="story-title">
            <div
                class="container-site grid items-center gap-14 lg:grid-cols-2 lg:gap-20"
            >
                <div
                    v-reveal
                    class="relative mx-auto w-full max-w-md lg:order-2 lg:max-w-none"
                >
                    <div
                        aria-hidden="true"
                        class="absolute -inset-4 rotate-3 rounded-[2.5rem] bg-linear-to-br from-sky-200/70 to-blue-100/40 dark:from-sky-500/15 dark:to-blue-900/10"
                    />
                    <img
                        :srcset="imageSrcset('about-interior', [640, 960])"
                        sizes="(min-width: 1024px) 40vw, 90vw"
                        src="/images/about-interior-640.webp"
                        width="640"
                        height="800"
                        :alt="t('about.image_alt')"
                        loading="lazy"
                        decoding="async"
                        class="relative aspect-[4/5] w-full rounded-[2rem] object-cover shadow-2xl shadow-sky-900/10"
                    />
                    <SparkleMark
                        aria-hidden="true"
                        class="absolute -top-3 -left-3 size-10 text-accent motion-safe:animate-twinkle"
                    />
                </div>

                <div>
                    <SectionHeading
                        id="story-title"
                        align="start"
                        :eyebrow="t('about.eyebrow')"
                        :title="t('about.title')"
                        :subtitle="t('about.intro')"
                    />
                    <h3
                        class="mt-10 font-display text-xl font-medium text-foreground"
                    >
                        {{ t('about.story.title') }}
                    </h3>
                    <p
                        v-for="paragraph in paragraphs"
                        :key="paragraph"
                        class="mt-4 leading-relaxed text-foreground-muted"
                    >
                        {{ paragraph }}
                    </p>
                </div>
            </div>
        </section>

        <section
            class="bg-background-muted py-20 sm:py-24 lg:py-28"
            aria-labelledby="values-title"
        >
            <div class="container-site">
                <SectionHeading
                    id="values-title"
                    :title="t('about.values.title')"
                />
                <ul class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <li
                        v-for="(value, index) in values"
                        :key="value.title"
                        v-reveal="(index % 3) * 90"
                        class="group rounded-3xl border border-border bg-surface p-7 transition duration-300 hover:-translate-y-1 hover:border-accent/40 hover:shadow-xl hover:shadow-sky-900/5"
                    >
                        <span
                            class="grid size-12 place-items-center rounded-2xl bg-accent-soft text-accent-strong transition-transform duration-300 group-hover:rotate-6"
                        >
                            <component
                                :is="icons[index]"
                                class="size-5"
                                aria-hidden="true"
                            />
                        </span>
                        <h3
                            class="mt-5 font-display text-lg font-medium text-foreground"
                        >
                            {{ value.title }}
                        </h3>
                        <p
                            class="mt-2 text-sm leading-relaxed text-foreground-muted"
                        >
                            {{ value.text }}
                        </p>
                    </li>
                </ul>
            </div>
        </section>

        <CtaSection class="pt-20 sm:pt-24 lg:pt-28" />
    </div>
</template>
