<script setup lang="ts">
import { Monitor, Moon, Sun } from '@lucide/vue';
import { computed, onBeforeUnmount, onMounted, ref, useId } from 'vue';
import { useAppearance } from '@/composables/useAppearance';
import type { Appearance } from '@/composables/useAppearance';
import { useI18n } from '@/composables/useI18n';
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        /** `compact`: an icon button opening a small panel. `inline`: a segmented control. */
        variant?: 'compact' | 'inline';
        inverse?: boolean;
    }>(),
    { variant: 'inline', inverse: false },
);

const { t } = useI18n();
const { appearance, updateAppearance } = useAppearance();

const groupName = `theme-${useId()}`;
const panelId = `theme-panel-${useId()}`;
const isOpen = ref(false);
const root = ref<HTMLElement | null>(null);
const toggleButton = ref<HTMLButtonElement | null>(null);

const options = computed(() => [
    { value: 'light' as const, label: t('common.theme.light'), icon: Sun },
    { value: 'dark' as const, label: t('common.theme.dark'), icon: Moon },
    {
        value: 'system' as const,
        label: t('common.theme.system'),
        icon: Monitor,
    },
]);

const current = computed(
    () =>
        options.value.find((option) => option.value === appearance.value) ??
        options.value[2],
);

function select(value: Appearance): void {
    updateAppearance(value);
}

function close(returnFocus = false): void {
    isOpen.value = false;

    if (returnFocus) {
        toggleButton.value?.focus();
    }
}

function onDocumentPointerDown(event: PointerEvent): void {
    if (isOpen.value && !root.value?.contains(event.target as Node)) {
        close();
    }
}

onMounted(() =>
    document.addEventListener('pointerdown', onDocumentPointerDown),
);
onBeforeUnmount(() =>
    document.removeEventListener('pointerdown', onDocumentPointerDown),
);
</script>

<template>
    <div ref="root" class="relative" @keydown.esc="close(true)">
        <template v-if="props.variant === 'compact'">
            <button
                ref="toggleButton"
                type="button"
                class="grid size-10 place-items-center rounded-full border border-border bg-surface text-foreground-muted transition hover:border-accent hover:text-accent-strong"
                :aria-label="`${t('common.theme.label')} : ${current.label}`"
                :aria-expanded="isOpen"
                :aria-controls="panelId"
                @click="isOpen = !isOpen"
            >
                <component
                    :is="current.icon"
                    class="size-[1.05rem]"
                    aria-hidden="true"
                />
            </button>

            <Transition
                enter-active-class="transition duration-150 ease-out"
                enter-from-class="translate-y-1 scale-95 opacity-0"
                leave-active-class="transition duration-100 ease-in"
                leave-to-class="translate-y-1 scale-95 opacity-0"
            >
                <div
                    v-show="isOpen"
                    :id="panelId"
                    class="absolute right-0 z-50 mt-2 w-44 origin-top-right rounded-2xl border border-border bg-surface p-1.5 shadow-xl shadow-black/10"
                >
                    <fieldset>
                        <legend
                            class="px-2.5 pt-1.5 pb-2 text-xs font-medium text-foreground-muted"
                        >
                            {{ t('common.theme.label') }}
                        </legend>
                        <label
                            v-for="option in options"
                            :key="option.value"
                            class="flex cursor-pointer items-center gap-2.5 rounded-xl px-2.5 py-2 text-sm transition has-focus-visible:outline-2 has-focus-visible:outline-ring"
                            :class="
                                appearance === option.value
                                    ? 'bg-accent-soft font-medium text-accent-strong'
                                    : 'text-foreground hover:bg-surface-muted'
                            "
                        >
                            <input
                                type="radio"
                                class="sr-only"
                                :name="groupName"
                                :value="option.value"
                                :checked="appearance === option.value"
                                @change="select(option.value)"
                                @keydown.enter.prevent="close(true)"
                            />
                            <component
                                :is="option.icon"
                                class="size-4"
                                aria-hidden="true"
                            />
                            {{ option.label }}
                        </label>
                    </fieldset>
                </div>
            </Transition>
        </template>

        <fieldset v-else>
            <legend class="sr-only">{{ t('common.theme.label') }}</legend>
            <div
                :class="
                    cn(
                        'inline-flex rounded-full border p-1',
                        props.inverse
                            ? 'border-white/15 bg-white/5'
                            : 'border-border bg-surface-muted',
                    )
                "
            >
                <label
                    v-for="option in options"
                    :key="option.value"
                    :class="
                        cn(
                            'flex min-h-9 cursor-pointer items-center gap-1.5 rounded-full px-3 text-xs font-medium transition has-focus-visible:outline-2 has-focus-visible:outline-ring',
                            appearance === option.value
                                ? props.inverse
                                    ? 'bg-white text-brand-navy shadow-sm'
                                    : 'bg-surface text-accent-strong shadow-sm'
                                : props.inverse
                                  ? 'text-slate-300 hover:text-white'
                                  : 'text-foreground-muted hover:text-foreground',
                        )
                    "
                >
                    <input
                        type="radio"
                        class="sr-only"
                        :name="groupName"
                        :value="option.value"
                        :checked="appearance === option.value"
                        @change="select(option.value)"
                    />
                    <component
                        :is="option.icon"
                        class="size-3.5"
                        aria-hidden="true"
                    />
                    {{ option.label }}
                </label>
            </div>
        </fieldset>
    </div>
</template>
