<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from '@lucide/vue';
import { computed } from 'vue';
import PageHero from '@/components/sections/PageHero.vue';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import type { LegalDocumentContent, SitePageName } from '@/types';

const props = defineProps<{
    document: LegalDocumentContent;
}>();

const { t } = useI18n();
const { pageUrl, isCurrent } = useSiteRoutes();

const relatedDocuments = computed(() =>
    (['legal_notice', 'privacy_policy', 'terms'] as SitePageName[])
        .filter((name) => !isCurrent(name))
        .map((name) => ({ name, label: t(`nav.${name}`) })),
);
</script>

<template>
    <div>
        <PageHero
            :eyebrow="props.document.eyebrow"
            :title="props.document.title"
            :intro="props.document.intro"
        >
            <p class="text-sm text-foreground-muted">
                {{ props.document.updatedAt }}
            </p>
        </PageHero>

        <div class="container-site py-16 sm:py-20">
            <article class="mx-auto max-w-3xl">
                <section
                    v-for="(section, index) in props.document.sections"
                    :key="section.heading"
                    class="border-b border-border py-8 first:pt-0 last:border-b-0"
                    :aria-labelledby="`legal-section-${index}`"
                >
                    <h2
                        :id="`legal-section-${index}`"
                        class="font-display text-2xl font-medium text-foreground"
                    >
                        {{ section.heading }}
                    </h2>
                    <p
                        v-for="paragraph in section.paragraphs"
                        :key="paragraph"
                        class="mt-4 leading-relaxed text-foreground-muted"
                    >
                        {{ paragraph }}
                    </p>
                    <ul
                        v-if="section.list"
                        class="mt-4 flex list-disc flex-col gap-2 pl-5 leading-relaxed text-foreground-muted marker:text-accent"
                    >
                        <li v-for="item in section.list" :key="item">
                            {{ item }}
                        </li>
                    </ul>
                    <p
                        v-for="paragraph in section.after"
                        :key="paragraph"
                        class="mt-4 leading-relaxed text-foreground-muted"
                    >
                        {{ paragraph }}
                    </p>
                </section>

                <nav
                    class="mt-12 rounded-3xl border border-border bg-surface-muted p-6"
                    :aria-label="props.document.relatedTitle"
                >
                    <h2 class="text-sm font-semibold text-foreground">
                        {{ props.document.relatedTitle }}
                    </h2>
                    <ul class="mt-3 flex flex-col gap-2 sm:flex-row sm:gap-6">
                        <li v-for="item in relatedDocuments" :key="item.name">
                            <Link
                                :href="pageUrl(item.name)"
                                class="inline-flex items-center gap-1.5 rounded text-sm font-medium text-accent-strong hover:underline"
                            >
                                {{ item.label }}
                                <ArrowRight
                                    class="size-3.5"
                                    aria-hidden="true"
                                />
                            </Link>
                        </li>
                    </ul>
                </nav>
            </article>
        </div>
    </div>
</template>
