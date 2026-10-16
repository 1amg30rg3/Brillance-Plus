<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import {
    ArrowRight,
    Building,
    ChevronDown,
    CircleAlert,
    CircleCheckBig,
    House,
    Info,
    LoaderCircle,
    Sparkles,
} from '@lucide/vue';
import { computed, nextTick, onMounted, ref } from 'vue';
import FormField from '@/components/contact/FormField.vue';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { buttonClasses } from '@/lib/button';
import { inputClasses } from '@/lib/form';
import { recommendedPackage } from '@/lib/services';
import { cn } from '@/lib/utils';
import type { InquiryOptions, InquiryPrefill } from '@/types';

const props = defineProps<{
    options: InquiryOptions;
    prefill: InquiryPrefill;
    formToken: string;
}>();

const page = usePage();
const { t, locale } = useI18n();
const { pageUrl, inquiryStoreRoute } = useSiteRoutes();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    preferred_language: locale.value as string,
    property_type: props.prefill.property_type ?? '',
    property_size: '' as number | '',
    rooms: '' as number | '',
    service: props.prefill.service ?? '',
    package: props.prefill.package ?? '',
    frequency: '',
    preferred_date: '',
    preferred_time_slot: '',
    message: '',
    privacy_consent: false,
    website: '',
    form_token: '',
});

/** Fields in display order, used to list errors in the summary. */
const fieldOrder = [
    'name',
    'email',
    'phone',
    'preferred_language',
    'property_type',
    'property_size',
    'rooms',
    'service',
    'package',
    'frequency',
    'preferred_date',
    'preferred_time_slot',
    'message',
    'privacy_consent',
] as const;

type Field = (typeof fieldOrder)[number];

const isSubmitted = ref(false);
const liveMessage = ref('');
const minDate = ref<string>();
const errorSummary = ref<HTMLElement | null>(null);
const successPanel = ref<HTMLElement | null>(null);

const errors = computed(
    () => form.errors as Partial<Record<Field | 'form', string>>,
);

const fieldErrors = computed(() =>
    fieldOrder
        .filter((field) => errors.value[field])
        .map((field) => ({ field, message: errors.value[field] as string })),
);

const hasErrors = computed(
    () => fieldErrors.value.length > 0 || Boolean(errors.value.form),
);

const consentParts = computed(() =>
    t('contact.form.fields.privacy_consent.label').split(':link'),
);

const propertyIcons: Record<string, typeof Building> = {
    apartment: Building,
    house: House,
};

function fieldId(field: Field): string {
    return `inquiry-${field}`;
}

function label(field: Field): string {
    return t(`contact.form.fields.${field}.label`);
}

onMounted(() => {
    // Computed in the browser so the minimum date follows the visitor's own calendar day.
    const now = new Date();
    minDate.value = new Date(now.getTime() - now.getTimezoneOffset() * 60_000)
        .toISOString()
        .slice(0, 10);
});

function submit(): void {
    if (form.processing) {
        return;
    }

    form.transform((data) => ({ ...data, form_token: props.formToken })).submit(
        inquiryStoreRoute.value,
        {
            preserveScroll: true,
            onSuccess: () => {
                // Success is only shown when the server confirms the inquiry was saved.
                if (page.flash.inquiry !== 'received') {
                    return;
                }

                isSubmitted.value = true;
                liveMessage.value = `${t('contact.form.success.title')} ${t('contact.form.success.text')}`;
                form.reset();
                void nextTick(() => successPanel.value?.focus());
            },
            onError: () => {
                void nextTick(() => errorSummary.value?.focus());
            },
        },
    );
}

function startNewRequest(): void {
    isSubmitted.value = false;
    liveMessage.value = '';
}

const sectionTitleClasses =
    'flex items-center gap-3 font-display text-lg font-medium text-foreground';
const sectionNumberClasses =
    'grid size-7 place-items-center rounded-full bg-accent-soft font-sans text-xs font-semibold text-accent-strong';
</script>

<template>
    <div
        class="rounded-[2rem] border border-border bg-surface p-6 shadow-xl shadow-sky-900/5 sm:p-10 dark:shadow-black/30"
    >
        <p class="sr-only" aria-live="polite">{{ liveMessage }}</p>

        <div
            v-if="isSubmitted"
            ref="successPanel"
            tabindex="-1"
            class="flex flex-col items-center py-10 text-center focus:outline-none motion-safe:animate-fade-up"
        >
            <span
                class="grid size-16 place-items-center rounded-full bg-success-soft text-success"
            >
                <CircleCheckBig class="size-8" aria-hidden="true" />
            </span>
            <h2 class="mt-6 font-display text-3xl font-medium text-foreground">
                {{ t('contact.form.success.title') }}
            </h2>
            <p class="mt-3 max-w-md text-foreground-muted">
                {{ t('contact.form.success.text') }}
            </p>
            <p
                class="mt-6 flex max-w-md items-start gap-2.5 rounded-2xl bg-surface-muted p-4 text-left text-sm text-foreground-muted"
            >
                <Info
                    class="mt-0.5 size-4 shrink-0 text-accent-strong"
                    aria-hidden="true"
                />
                {{ t('contact.form.not_a_booking') }}
            </p>
            <button
                type="button"
                :class="buttonClasses('secondary', 'md', 'mt-8')"
                @click="startNewRequest"
            >
                {{ t('contact.form.success.again') }}
            </button>
        </div>

        <form
            v-else
            novalidate
            class="flex flex-col gap-10"
            aria-labelledby="inquiry-form-title"
            @submit.prevent="submit"
        >
            <div>
                <h2
                    id="inquiry-form-title"
                    class="font-display text-3xl font-medium tracking-tight text-foreground sm:text-4xl"
                >
                    {{ t('contact.form.title') }}
                </h2>
                <p class="mt-3 text-foreground-muted">
                    {{ t('contact.form.subtitle') }}
                </p>
                <p class="mt-4 text-sm text-foreground-muted">
                    {{ t('contact.form.required_hint') }}
                </p>
            </div>

            <div
                v-if="hasErrors"
                ref="errorSummary"
                tabindex="-1"
                role="alert"
                class="rounded-2xl border border-danger/30 bg-danger-soft p-5 text-sm text-danger focus:outline-none"
            >
                <p class="flex items-start gap-2.5 font-semibold">
                    <CircleAlert
                        class="mt-0.5 size-4 shrink-0"
                        aria-hidden="true"
                    />
                    {{ errors.form ?? t('contact.form.error_summary') }}
                </p>
                <ul
                    v-if="fieldErrors.length"
                    class="mt-3 flex list-disc flex-col gap-1 pl-11"
                >
                    <li v-for="item in fieldErrors" :key="item.field">
                        <a
                            :href="`#${fieldId(item.field)}`"
                            class="underline underline-offset-2 hover:no-underline"
                        >
                            {{ item.message }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 1. Contact details -->
            <section
                class="flex flex-col gap-5"
                aria-labelledby="inquiry-section-contact"
            >
                <h3 id="inquiry-section-contact" :class="sectionTitleClasses">
                    <span :class="sectionNumberClasses" aria-hidden="true"
                        >1</span
                    >
                    {{ t('contact.form.sections.contact') }}
                </h3>

                <FormField
                    :id="fieldId('name')"
                    v-slot="{ describedBy, invalid }"
                    :label="label('name')"
                    :error="errors.name"
                    required
                >
                    <input
                        :id="fieldId('name')"
                        v-model="form.name"
                        type="text"
                        name="name"
                        autocomplete="name"
                        required
                        maxlength="120"
                        :placeholder="t('contact.form.fields.name.placeholder')"
                        :aria-invalid="invalid"
                        :aria-describedby="describedBy"
                        :class="cn(inputClasses, 'h-12')"
                    />
                </FormField>

                <div class="grid gap-5 sm:grid-cols-2">
                    <FormField
                        :id="fieldId('email')"
                        v-slot="{ describedBy, invalid }"
                        :label="label('email')"
                        :error="errors.email"
                        required
                    >
                        <input
                            :id="fieldId('email')"
                            v-model="form.email"
                            type="email"
                            name="email"
                            autocomplete="email"
                            inputmode="email"
                            required
                            maxlength="190"
                            :placeholder="
                                t('contact.form.fields.email.placeholder')
                            "
                            :aria-invalid="invalid"
                            :aria-describedby="describedBy"
                            :class="cn(inputClasses, 'h-12')"
                        />
                    </FormField>
                    <FormField
                        :id="fieldId('phone')"
                        v-slot="{ describedBy, invalid }"
                        :label="label('phone')"
                        :error="errors.phone"
                        required
                    >
                        <input
                            :id="fieldId('phone')"
                            v-model="form.phone"
                            type="tel"
                            name="phone"
                            autocomplete="tel"
                            inputmode="tel"
                            required
                            maxlength="32"
                            :placeholder="
                                t('contact.form.fields.phone.placeholder')
                            "
                            :aria-invalid="invalid"
                            :aria-describedby="describedBy"
                            :class="cn(inputClasses, 'h-12')"
                        />
                    </FormField>
                </div>

                <FormField
                    :id="fieldId('preferred_language')"
                    v-slot="{ describedBy, invalid }"
                    :label="label('preferred_language')"
                    :error="errors.preferred_language"
                >
                    <div class="relative sm:max-w-xs">
                        <select
                            :id="fieldId('preferred_language')"
                            v-model="form.preferred_language"
                            name="preferred_language"
                            :aria-invalid="invalid"
                            :aria-describedby="describedBy"
                            :class="
                                cn(inputClasses, 'h-12 appearance-none pr-11')
                            "
                        >
                            <option
                                v-for="option in props.options.languages"
                                :key="option.value"
                                :value="option.value"
                                :lang="option.value"
                            >
                                {{ option.label }}
                            </option>
                        </select>
                        <ChevronDown
                            class="pointer-events-none absolute top-1/2 right-4 size-4 -translate-y-1/2 text-foreground-muted"
                            aria-hidden="true"
                        />
                    </div>
                </FormField>
            </section>

            <!-- 2. Property -->
            <section
                class="flex flex-col gap-5 border-t border-border pt-10"
                aria-labelledby="inquiry-section-property"
            >
                <h3 id="inquiry-section-property" :class="sectionTitleClasses">
                    <span :class="sectionNumberClasses" aria-hidden="true"
                        >2</span
                    >
                    {{ t('contact.form.sections.property') }}
                </h3>

                <FormField
                    :id="fieldId('property_type')"
                    group
                    :label="label('property_type')"
                    :error="errors.property_type"
                    required
                >
                    <div class="grid grid-cols-2 gap-3">
                        <label
                            v-for="option in props.options.propertyTypes"
                            :key="option.value"
                            :class="
                                cn(
                                    'group flex cursor-pointer items-center gap-3 rounded-2xl border p-4 transition duration-200 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-ring',
                                    form.property_type === option.value
                                        ? 'border-accent bg-accent-soft shadow-sm'
                                        : 'border-border-strong hover:border-accent/60',
                                )
                            "
                        >
                            <input
                                v-model="form.property_type"
                                type="radio"
                                name="property_type"
                                :value="option.value"
                                class="sr-only"
                                required
                            />
                            <span
                                :class="
                                    cn(
                                        'grid size-10 shrink-0 place-items-center rounded-xl transition-colors',
                                        form.property_type === option.value
                                            ? 'bg-accent text-white dark:text-brand-navy'
                                            : 'bg-surface-muted text-accent-strong',
                                    )
                                "
                            >
                                <component
                                    :is="
                                        propertyIcons[option.value] ?? Building
                                    "
                                    class="size-5"
                                    aria-hidden="true"
                                />
                            </span>
                            <span class="font-medium text-foreground">{{
                                option.label
                            }}</span>
                        </label>
                    </div>
                </FormField>

                <div class="grid gap-5 sm:grid-cols-2">
                    <FormField
                        :id="fieldId('property_size')"
                        v-slot="{ describedBy, invalid }"
                        :label="label('property_size')"
                        :error="errors.property_size"
                    >
                        <div class="relative">
                            <input
                                :id="fieldId('property_size')"
                                v-model.number="form.property_size"
                                type="number"
                                name="property_size"
                                inputmode="numeric"
                                min="5"
                                max="2000"
                                :placeholder="
                                    t(
                                        'contact.form.fields.property_size.placeholder',
                                    )
                                "
                                :aria-invalid="invalid"
                                :aria-describedby="describedBy"
                                :class="cn(inputClasses, 'h-12 pr-14')"
                            />
                            <span
                                class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-sm text-foreground-muted"
                                aria-hidden="true"
                            >
                                {{
                                    t(
                                        'contact.form.fields.property_size.suffix',
                                    )
                                }}
                            </span>
                        </div>
                    </FormField>
                    <FormField
                        :id="fieldId('rooms')"
                        v-slot="{ describedBy, invalid }"
                        :label="label('rooms')"
                        :error="errors.rooms"
                    >
                        <input
                            :id="fieldId('rooms')"
                            v-model.number="form.rooms"
                            type="number"
                            name="rooms"
                            inputmode="numeric"
                            min="1"
                            max="30"
                            :placeholder="
                                t('contact.form.fields.rooms.placeholder')
                            "
                            :aria-invalid="invalid"
                            :aria-describedby="describedBy"
                            :class="cn(inputClasses, 'h-12')"
                        />
                    </FormField>
                </div>
            </section>

            <!-- 3. Service -->
            <section
                class="flex flex-col gap-5 border-t border-border pt-10"
                aria-labelledby="inquiry-section-service"
            >
                <h3 id="inquiry-section-service" :class="sectionTitleClasses">
                    <span :class="sectionNumberClasses" aria-hidden="true"
                        >3</span
                    >
                    {{ t('contact.form.sections.service') }}
                </h3>

                <FormField
                    :id="fieldId('service')"
                    v-slot="{ describedBy, invalid }"
                    :label="label('service')"
                    :error="errors.service"
                    required
                >
                    <div class="relative">
                        <select
                            :id="fieldId('service')"
                            v-model="form.service"
                            name="service"
                            required
                            :aria-invalid="invalid"
                            :aria-describedby="describedBy"
                            :class="
                                cn(
                                    inputClasses,
                                    'h-12 appearance-none pr-11',
                                    !form.service && 'text-foreground-muted',
                                )
                            "
                        >
                            <option value="" disabled>
                                {{ t('contact.form.select_placeholder') }}
                            </option>
                            <option
                                v-for="option in props.options.services"
                                :key="option.value"
                                :value="option.value"
                                class="text-foreground"
                            >
                                {{ option.label }}
                            </option>
                        </select>
                        <ChevronDown
                            class="pointer-events-none absolute top-1/2 right-4 size-4 -translate-y-1/2 text-foreground-muted"
                            aria-hidden="true"
                        />
                    </div>
                </FormField>

                <FormField
                    :id="fieldId('package')"
                    group
                    :label="label('package')"
                    :hint="t('contact.form.fields.package.help')"
                    :error="errors.package"
                >
                    <div class="grid gap-3 sm:grid-cols-2">
                        <label
                            v-for="option in [
                                {
                                    value: '',
                                    label: t('contact.form.undecided_package'),
                                },
                                ...props.options.packages,
                            ]"
                            :key="option.value"
                            :class="
                                cn(
                                    'relative flex cursor-pointer flex-col gap-1 rounded-2xl border p-4 transition duration-200 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-ring',
                                    form.package === option.value
                                        ? 'border-accent bg-accent-soft shadow-sm'
                                        : 'border-border-strong hover:border-accent/60',
                                )
                            "
                        >
                            <input
                                v-model="form.package"
                                type="radio"
                                name="package"
                                :value="option.value"
                                class="sr-only"
                            />
                            <span
                                class="flex items-center justify-between gap-2 font-medium text-foreground"
                            >
                                {{ option.label }}
                                <span
                                    v-if="option.value === recommendedPackage"
                                    class="inline-flex items-center gap-1 rounded-full bg-primary px-2 py-0.5 text-[0.7rem] font-semibold text-primary-foreground"
                                >
                                    <Sparkles
                                        class="size-3"
                                        aria-hidden="true"
                                    />
                                    {{ t('contact.form.recommended') }}
                                </span>
                            </span>
                            <span class="text-sm text-foreground-muted">
                                {{
                                    option.value
                                        ? t(
                                              `packages.items.${option.value}.tagline`,
                                          )
                                        : t(
                                              'contact.form.undecided_package_text',
                                          )
                                }}
                            </span>
                        </label>
                    </div>
                </FormField>

                <FormField
                    :id="fieldId('frequency')"
                    group
                    :label="label('frequency')"
                    :error="errors.frequency"
                    required
                >
                    <div class="flex flex-wrap gap-2.5">
                        <label
                            v-for="option in props.options.frequencies"
                            :key="option.value"
                            :class="
                                cn(
                                    'flex min-h-11 cursor-pointer items-center rounded-full border px-4 text-sm font-medium transition duration-200 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-ring',
                                    form.frequency === option.value
                                        ? 'border-accent bg-accent text-white dark:text-brand-navy'
                                        : 'border-border-strong text-foreground hover:border-accent/60',
                                )
                            "
                        >
                            <input
                                v-model="form.frequency"
                                type="radio"
                                name="frequency"
                                :value="option.value"
                                class="sr-only"
                                required
                            />
                            {{ option.label }}
                        </label>
                    </div>
                </FormField>

                <div class="grid gap-5 sm:grid-cols-2">
                    <FormField
                        :id="fieldId('preferred_date')"
                        v-slot="{ describedBy, invalid }"
                        :label="label('preferred_date')"
                        :error="errors.preferred_date"
                    >
                        <input
                            :id="fieldId('preferred_date')"
                            v-model="form.preferred_date"
                            type="date"
                            name="preferred_date"
                            :min="minDate"
                            :aria-invalid="invalid"
                            :aria-describedby="describedBy"
                            :class="cn(inputClasses, 'h-12')"
                        />
                    </FormField>
                    <FormField
                        :id="fieldId('preferred_time_slot')"
                        v-slot="{ describedBy, invalid }"
                        :label="label('preferred_time_slot')"
                        :error="errors.preferred_time_slot"
                    >
                        <div class="relative">
                            <select
                                :id="fieldId('preferred_time_slot')"
                                v-model="form.preferred_time_slot"
                                name="preferred_time_slot"
                                :aria-invalid="invalid"
                                :aria-describedby="describedBy"
                                :class="
                                    cn(
                                        inputClasses,
                                        'h-12 appearance-none pr-11',
                                    )
                                "
                            >
                                <option value="">
                                    {{ t('contact.form.no_preference') }}
                                </option>
                                <option
                                    v-for="option in props.options.timeSlots"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </option>
                            </select>
                            <ChevronDown
                                class="pointer-events-none absolute top-1/2 right-4 size-4 -translate-y-1/2 text-foreground-muted"
                                aria-hidden="true"
                            />
                        </div>
                    </FormField>
                </div>
            </section>

            <!-- 4. Details and consent -->
            <section
                class="flex flex-col gap-5 border-t border-border pt-10"
                aria-labelledby="inquiry-section-details"
            >
                <h3 id="inquiry-section-details" :class="sectionTitleClasses">
                    <span :class="sectionNumberClasses" aria-hidden="true"
                        >4</span
                    >
                    {{ t('contact.form.sections.details') }}
                </h3>

                <FormField
                    :id="fieldId('message')"
                    v-slot="{ describedBy, invalid }"
                    :label="label('message')"
                    :error="errors.message"
                >
                    <textarea
                        :id="fieldId('message')"
                        v-model="form.message"
                        name="message"
                        rows="5"
                        maxlength="2000"
                        :placeholder="
                            t('contact.form.fields.message.placeholder')
                        "
                        :aria-invalid="invalid"
                        :aria-describedby="describedBy"
                        :class="
                            cn(inputClasses, 'resize-y py-3 leading-relaxed')
                        "
                    />
                </FormField>

                <!-- Honeypot: hidden from people, often filled in by spam bots. -->
                <div
                    class="absolute -left-[10000px] h-px w-px overflow-hidden"
                    aria-hidden="true"
                >
                    <label for="inquiry-website">{{
                        t('contact.form.fields.website.label')
                    }}</label>
                    <input
                        id="inquiry-website"
                        v-model="form.website"
                        type="text"
                        name="website"
                        tabindex="-1"
                        autocomplete="off"
                    />
                </div>

                <div
                    :id="fieldId('privacy_consent')"
                    class="flex flex-col gap-2"
                >
                    <label
                        class="flex cursor-pointer items-start gap-3 text-sm leading-relaxed text-foreground"
                    >
                        <input
                            v-model="form.privacy_consent"
                            type="checkbox"
                            name="privacy_consent"
                            required
                            :aria-invalid="Boolean(errors.privacy_consent)"
                            :aria-describedby="
                                errors.privacy_consent
                                    ? 'privacy-consent-error'
                                    : undefined
                            "
                            class="mt-0.5 size-5 shrink-0 cursor-pointer rounded-md border-border-strong accent-[var(--primary)]"
                        />
                        <span>
                            {{ consentParts[0]
                            }}<a
                                :href="pageUrl('privacy_policy')"
                                target="_blank"
                                rel="noopener"
                                class="font-medium text-accent-strong underline underline-offset-2 hover:no-underline"
                                >{{
                                    t(
                                        'contact.form.fields.privacy_consent.link',
                                    )
                                }}<span class="sr-only">
                                    {{ t('contact.form.new_tab') }}</span
                                ></a
                            >{{ consentParts[1] }}
                            <span class="text-danger" aria-hidden="true"
                                >*</span
                            >
                        </span>
                    </label>
                    <p
                        v-if="errors.privacy_consent"
                        id="privacy-consent-error"
                        class="flex items-start gap-1.5 pl-8 text-sm text-danger"
                    >
                        <CircleAlert
                            class="mt-0.5 size-4 shrink-0"
                            aria-hidden="true"
                        />
                        {{ errors.privacy_consent }}
                    </p>
                </div>
            </section>

            <div
                class="flex flex-col gap-5 border-t border-border pt-8 sm:flex-row sm:items-center sm:justify-between"
            >
                <p
                    class="flex items-start gap-2.5 text-sm text-foreground-muted sm:max-w-sm"
                >
                    <Info
                        class="mt-0.5 size-4 shrink-0 text-accent-strong"
                        aria-hidden="true"
                    />
                    {{ t('contact.form.not_a_booking') }}
                </p>
                <button
                    type="submit"
                    :disabled="form.processing"
                    :aria-busy="form.processing"
                    :class="
                        buttonClasses('primary', 'lg', 'group w-full sm:w-auto')
                    "
                >
                    <LoaderCircle
                        v-if="form.processing"
                        class="size-4 animate-spin"
                        aria-hidden="true"
                    />
                    {{
                        form.processing
                            ? t('contact.form.submitting')
                            : t('contact.form.submit')
                    }}
                    <ArrowRight
                        v-if="!form.processing"
                        class="size-4 transition-transform group-hover:translate-x-0.5"
                        aria-hidden="true"
                    />
                </button>
            </div>
        </form>
    </div>
</template>
