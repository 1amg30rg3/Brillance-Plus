<script setup lang="ts">
import SparkleMark from '@/components/brand/SparkleMark.vue';

withDefaults(defineProps<{ inverse?: boolean }>(), { inverse: false });
</script>

<template>
    <span class="inline-flex items-center gap-2.5">
        <span
            class="relative grid size-9 shrink-0 place-items-center rounded-xl bg-linear-to-br from-brand-sky to-brand-deep shadow-md shadow-sky-500/25"
        >
            <SparkleMark class="size-5 text-white" />
            <SparkleMark
                class="absolute top-1 right-1 size-2 text-white/85 motion-safe:animate-twinkle"
            />
        </span>
        <span class="flex items-baseline gap-1.5 leading-none">
            <span
                class="font-display text-[1.35rem] font-semibold tracking-tight"
                :class="inverse ? 'text-white' : 'text-foreground'"
            >
                Brillance
            </span>
            <span
                class="text-[0.68rem] font-semibold tracking-[0.24em] uppercase"
                :class="inverse ? 'text-sky-300' : 'text-accent-strong'"
            >
                Plus
            </span>
        </span>
    </span>
</template>
