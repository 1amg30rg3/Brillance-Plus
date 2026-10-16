<script setup lang="ts">
import SparkleMark from '@/components/brand/SparkleMark.vue';
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        eyebrow?: string;
        title: string;
        subtitle?: string;
        align?: 'center' | 'start';
        as?: 'h1' | 'h2';
        id?: string;
    }>(),
    {
        align: 'center',
        as: 'h2',
        eyebrow: undefined,
        subtitle: undefined,
        id: undefined,
    },
);
</script>

<template>
    <div
        v-reveal
        :class="
            cn('max-w-2xl', props.align === 'center' && 'mx-auto text-center')
        "
    >
        <p
            v-if="props.eyebrow"
            :class="
                cn(
                    'inline-flex items-center gap-2 text-xs font-semibold tracking-[0.18em] text-accent-strong uppercase',
                    props.align === 'center' && 'justify-center',
                )
            "
        >
            <SparkleMark class="size-3 text-accent" />
            {{ props.eyebrow }}
        </p>
        <component
            :is="props.as"
            :id="props.id"
            class="mt-4 font-display text-3xl font-medium tracking-tight text-foreground sm:text-4xl lg:text-[2.75rem] lg:leading-[1.12]"
        >
            {{ props.title }}
        </component>
        <p
            v-if="props.subtitle"
            class="mt-4 text-base leading-relaxed text-foreground-muted sm:text-lg"
        >
            {{ props.subtitle }}
        </p>
        <slot />
    </div>
</template>
