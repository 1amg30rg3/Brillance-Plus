<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Check } from '@lucide/vue';
import { computed } from 'vue';
import SparkleMark from '@/components/brand/SparkleMark.vue';
import SectionHeading from '@/components/sections/SectionHeading.vue';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { buttonClasses } from '@/lib/button';
import { imageSrcset } from '@/lib/services';

const { t, tm } = useI18n();
const { pageUrl } = useSiteRoutes();

const points = computed(() => tm<string[]>('home.about.points'));
</script>

<template>
    <section
        class="overflow-hidden bg-background-muted py-20 sm:py-24 lg:py-28"
        aria-labelledby="about-teaser-title"
    >
        <div
            class="container-site grid items-center gap-14 lg:grid-cols-2 lg:gap-20"
        >
            <div
                v-reveal
                class="relative mx-auto w-full max-w-md lg:max-w-none"
            >
                <div
                    aria-hidden="true"
                    class="absolute -inset-4 -rotate-3 rounded-[2.5rem] bg-linear-to-br from-sky-200/70 to-blue-100/40 dark:from-sky-500/15 dark:to-blue-900/10"
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
                    class="relative aspect-[4/5] w-full rounded-[2rem] object-cover shadow-2xl shadow-sky-900/10 lg:aspect-[5/6]"
                />
                <SparkleMark
                    aria-hidden="true"
                    class="absolute -right-3 -bottom-3 size-10 text-accent motion-safe:animate-twinkle"
                />
            </div>

            <div>
                <SectionHeading
                    id="about-teaser-title"
                    align="start"
                    :eyebrow="t('home.about.eyebrow')"
                    :title="t('home.about.title')"
                    :subtitle="t('home.about.text')"
                />
                <ul class="mt-8 flex flex-col gap-4">
                    <li
                        v-for="(point, index) in points"
                        :key="point"
                        v-reveal="index * 80"
                        class="flex items-center gap-3 text-foreground"
                    >
                        <span
                            class="grid size-7 shrink-0 place-items-center rounded-full bg-accent-soft text-accent-strong"
                        >
                            <Check class="size-4" aria-hidden="true" />
                        </span>
                        {{ point }}
                    </li>
                </ul>
                <Link
                    :href="pageUrl('about')"
                    :class="buttonClasses('secondary', 'md', 'group mt-10')"
                >
                    {{ t('common.cta.about') }}
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-0.5"
                        aria-hidden="true"
                    />
                </Link>
            </div>
        </div>
    </section>
</template>
