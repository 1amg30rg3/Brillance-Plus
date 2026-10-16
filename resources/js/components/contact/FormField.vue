<script setup lang="ts">
import { CircleAlert } from '@lucide/vue';
import { computed } from 'vue';
import { useI18n } from '@/composables/useI18n';

const props = withDefaults(
    defineProps<{
        id: string;
        label: string;
        error?: string;
        hint?: string;
        required?: boolean;
        /** Render a <fieldset> + <legend> for radio groups instead of a <label>. */
        group?: boolean;
    }>(),
    { error: undefined, hint: undefined, required: false, group: false },
);

const { t } = useI18n();

const hintId = computed(() => `${props.id}-hint`);
const errorId = computed(() => `${props.id}-error`);

const describedBy = computed(
    () =>
        [props.hint ? hintId.value : null, props.error ? errorId.value : null]
            .filter(Boolean)
            .join(' ') || undefined,
);
</script>

<template>
    <component
        :is="props.group ? 'fieldset' : 'div'"
        :id="props.group ? props.id : undefined"
        :tabindex="props.group ? -1 : undefined"
        class="flex min-w-0 scroll-mt-32 flex-col gap-2 focus:outline-none"
        :aria-describedby="props.group ? describedBy : undefined"
    >
        <component
            :is="props.group ? 'legend' : 'label'"
            :for="props.group ? undefined : props.id"
            class="mb-0.5 text-sm font-medium text-foreground"
        >
            {{ props.label }}
            <span v-if="props.required" class="text-danger" aria-hidden="true"
                >*</span
            >
            <span v-else class="font-normal text-foreground-muted"
                >({{ t('common.optional') }})</span
            >
        </component>

        <slot :described-by="describedBy" :invalid="Boolean(props.error)" />

        <p v-if="props.hint" :id="hintId" class="text-xs text-foreground-muted">
            {{ props.hint }}
        </p>
        <p
            v-if="props.error"
            :id="errorId"
            class="flex items-start gap-1.5 text-sm text-danger"
        >
            <CircleAlert class="mt-0.5 size-4 shrink-0" aria-hidden="true" />
            {{ props.error }}
        </p>
    </component>
</template>
