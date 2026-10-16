<script setup lang="ts">
import { Mail, Phone, Wallet } from '@lucide/vue';
import { computed } from 'vue';
import MessengerIcon from '@/components/brand/MessengerIcon.vue';
import WhatsAppIcon from '@/components/brand/WhatsAppIcon.vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';

const { t, tm } = useI18n();
const { business, phoneHref, emailHref, whatsappUrl, messengerUrl } =
    useBusiness();

const nextSteps = computed(() => tm<string[]>('contact.channels.next.items'));
</script>

<template>
    <aside
        class="flex flex-col gap-5 lg:sticky lg:top-28"
        :aria-label="t('contact.channels.title')"
    >
        <div
            class="relative overflow-hidden rounded-[2rem] bg-linear-to-br from-brand-deep to-brand-navy p-7 text-white shadow-xl shadow-sky-900/15"
        >
            <div
                aria-hidden="true"
                class="pointer-events-none absolute -top-16 -right-16 size-48 rounded-full bg-sky-400/25 blur-3xl"
            />
            <h2 class="relative font-display text-xl font-medium">
                {{ t('contact.channels.title') }}
            </h2>

            <a
                :href="phoneHref"
                class="group relative mt-6 flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:bg-white/10"
            >
                <span
                    class="grid size-11 shrink-0 place-items-center rounded-xl bg-sky-400/20 text-sky-300"
                >
                    <Phone class="size-5" aria-hidden="true" />
                </span>
                <span class="min-w-0">
                    <span class="block text-xs text-slate-300">{{
                        t('contact.channels.phone.label')
                    }}</span>
                    <span class="block font-display text-xl font-medium">{{
                        business.phoneDisplay
                    }}</span>
                    <span class="block text-xs text-slate-400">{{
                        t('contact.channels.phone.text')
                    }}</span>
                </span>
            </a>

            <a
                v-if="whatsappUrl"
                :href="whatsappUrl"
                target="_blank"
                rel="noopener noreferrer"
                class="group relative mt-3 flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:bg-white/10"
            >
                <span
                    class="grid size-11 shrink-0 place-items-center rounded-xl bg-[#25D366]/15 text-[#25D366]"
                >
                    <WhatsAppIcon class="size-5" />
                </span>
                <span class="min-w-0">
                    <span class="block text-xs text-slate-300">{{
                        t('contact.channels.whatsapp.label')
                    }}</span>
                    <span class="block font-medium"
                        >{{ t('common.messaging.whatsapp_action')
                        }}<span class="sr-only">
                            {{ t('common.messaging.new_tab') }}</span
                        ></span
                    >
                    <span class="block text-xs text-slate-400">{{
                        t('contact.channels.whatsapp.text')
                    }}</span>
                </span>
            </a>

            <a
                v-if="messengerUrl"
                :href="messengerUrl"
                target="_blank"
                rel="noopener noreferrer"
                class="group relative mt-3 flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:bg-white/10"
            >
                <span
                    class="grid size-11 shrink-0 place-items-center rounded-xl bg-[#4FA3FF]/15 text-[#4FA3FF]"
                >
                    <MessengerIcon class="size-5" />
                </span>
                <span class="min-w-0">
                    <span class="block text-xs text-slate-300">{{
                        t('contact.channels.messenger.label')
                    }}</span>
                    <span class="block font-medium"
                        >{{ t('common.messaging.messenger_action')
                        }}<span class="sr-only">
                            {{ t('common.messaging.new_tab') }}</span
                        ></span
                    >
                    <span class="block text-xs text-slate-400">{{
                        t('contact.channels.messenger.text')
                    }}</span>
                </span>
            </a>

            <a
                v-if="business.email && emailHref"
                :href="emailHref"
                class="group relative mt-3 flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:bg-white/10"
            >
                <span
                    class="grid size-11 shrink-0 place-items-center rounded-xl bg-sky-400/20 text-sky-300"
                >
                    <Mail class="size-5" aria-hidden="true" />
                </span>
                <span class="min-w-0">
                    <span class="block text-xs text-slate-300">{{
                        t('contact.channels.email.label')
                    }}</span>
                    <span class="block font-medium break-all">{{
                        business.email
                    }}</span>
                    <span class="block text-xs text-slate-400">{{
                        t('contact.channels.email.text')
                    }}</span>
                </span>
            </a>
        </div>

        <div class="rounded-[2rem] border border-border bg-surface p-7">
            <h2 class="flex items-center gap-2.5 font-semibold text-foreground">
                <span
                    class="grid size-9 place-items-center rounded-xl bg-accent-soft text-accent-strong"
                >
                    <Wallet class="size-4" aria-hidden="true" />
                </span>
                {{ t('contact.channels.payment.title') }}
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-foreground-muted">
                {{ t('contact.channels.payment.text') }}
            </p>
        </div>

        <div class="rounded-[2rem] border border-border bg-surface p-7">
            <h2 class="font-semibold text-foreground">
                {{ t('contact.channels.next.title') }}
            </h2>
            <ol class="mt-4 flex flex-col gap-4">
                <li
                    v-for="(step, index) in nextSteps"
                    :key="step"
                    class="flex items-start gap-3 text-sm text-foreground-muted"
                >
                    <span
                        class="grid size-6 shrink-0 place-items-center rounded-full bg-accent-soft text-xs font-semibold text-accent-strong"
                    >
                        {{ index + 1 }}
                    </span>
                    <span class="pt-0.5">{{ step }}</span>
                </li>
            </ol>
        </div>
    </aside>
</template>
