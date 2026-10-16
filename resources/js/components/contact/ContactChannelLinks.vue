<script setup lang="ts">
import { Phone } from '@lucide/vue';
import MessengerIcon from '@/components/brand/MessengerIcon.vue';
import WhatsAppIcon from '@/components/brand/WhatsAppIcon.vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        /** Light text for dark backgrounds. */
        inverse?: boolean;
        align?: 'center' | 'start';
    }>(),
    { inverse: false, align: 'start' },
);

const { t } = useI18n();
const { business, phoneHref, whatsappUrl, messengerUrl } = useBusiness();

const pillClasses = (): string =>
    cn(
        'inline-flex min-h-11 items-center gap-2 rounded-full border px-4 text-sm font-medium transition duration-200 hover:-translate-y-0.5',
        props.inverse
            ? 'border-white/20 text-white hover:border-white/40 hover:bg-white/10'
            : 'border-border-strong bg-surface text-foreground hover:border-accent hover:text-accent-strong',
    );
</script>

<template>
    <ul
        :class="
            cn(
                'flex flex-wrap gap-2.5',
                props.align === 'center' && 'justify-center',
            )
        "
    >
        <li>
            <a :href="phoneHref" :class="pillClasses()">
                <Phone class="size-4" aria-hidden="true" />
                {{ business.phoneDisplay }}
            </a>
        </li>
        <li v-if="whatsappUrl">
            <a
                :href="whatsappUrl"
                target="_blank"
                rel="noopener noreferrer"
                :class="pillClasses()"
                :aria-label="`${t('common.messaging.whatsapp_action')} ${t('common.messaging.new_tab')}`"
            >
                <WhatsAppIcon class="size-4 text-[#25D366]" />
                {{ t('common.messaging.whatsapp') }}
            </a>
        </li>
        <li v-if="messengerUrl">
            <a
                :href="messengerUrl"
                target="_blank"
                rel="noopener noreferrer"
                :class="pillClasses()"
                :aria-label="`${t('common.messaging.messenger_action')} ${t('common.messaging.new_tab')}`"
            >
                <MessengerIcon
                    :class="
                        cn(
                            'size-4',
                            props.inverse
                                ? 'text-[#4FA3FF]'
                                : 'text-[#0866FF] dark:text-[#4FA3FF]',
                        )
                    "
                />
                {{ t('common.messaging.messenger') }}
            </a>
        </li>
    </ul>
</template>
