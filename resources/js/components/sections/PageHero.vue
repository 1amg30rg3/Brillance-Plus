<script setup lang="ts">
import SparkleMark from '@/components/brand/SparkleMark.vue';

defineProps<{
    eyebrow: string;
    title: string;
    intro?: string;
}>();
</script>

<template>
    <section
        class="relative isolate overflow-hidden bg-linear-to-b from-background to-background-muted"
        aria-labelledby="page-title"
    >
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-0 -z-10"
        >
            <div
                class="absolute -top-24 right-[-10%] h-80 w-80 rounded-full bg-sky-300/25 blur-3xl dark:bg-sky-500/15"
            />
            <div
                class="absolute bottom-[-30%] left-[-10%] h-72 w-72 rounded-full bg-blue-300/20 blur-3xl dark:bg-blue-700/15"
            />
            <SparkleMark
                class="absolute top-16 right-[12%] size-6 text-accent/60 motion-safe:animate-twinkle"
            />
            <SparkleMark
                class="absolute right-[22%] bottom-12 size-3 text-accent/50 [animation-delay:1.5s] motion-safe:animate-twinkle"
            />
        </div>

        <div
            class="container-site pt-12 pb-14 sm:pt-16 sm:pb-20 lg:pt-20 lg:pb-24"
        >
            <div class="max-w-3xl">
                <p
                    class="inline-flex items-center gap-2 text-xs font-semibold tracking-[0.18em] text-accent-strong uppercase motion-safe:animate-fade-up"
                >
                    <SparkleMark class="size-3 text-accent" />
                    {{ eyebrow }}
                </p>
                <h1
                    id="page-title"
                    class="mt-5 font-display text-4xl font-medium tracking-tight text-foreground motion-safe:animate-fade-up motion-safe:[animation-delay:80ms] sm:text-5xl lg:text-6xl lg:leading-[1.05]"
                >
                    {{ title }}
                </h1>
                <p
                    v-if="intro"
                    class="mt-6 max-w-2xl text-base leading-relaxed text-foreground-muted motion-safe:animate-fade-up motion-safe:[animation-delay:160ms] sm:text-lg"
                >
                    {{ intro }}
                </p>
                <div
                    v-if="$slots.default"
                    class="mt-8 motion-safe:animate-fade-up motion-safe:[animation-delay:240ms]"
                >
                    <slot />
                </div>
            </div>
        </div>
    </section>
</template>
