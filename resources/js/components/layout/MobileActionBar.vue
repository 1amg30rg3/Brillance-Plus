<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Phone } from '@lucide/vue';
import WhatsAppIcon from '@/components/brand/WhatsAppIcon.vue';
import { useBusiness } from '@/composables/useBusiness';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { buttonClasses } from '@/lib/button';

const { t } = useI18n();
// The bar is hidden on the contact page, where the quote form is already on screen.
const { quoteUrl, isCurrent } = useSiteRoutes();
const { phoneHref, whatsappUrl } = useBusiness();

const iconButtonClasses = buttonClasses(
    'secondary',
    'md',
    'size-11 shrink-0 px-0',
);
</script>

<template>
    <aside
        v-if="!isCurrent('contact')"
        :aria-label="t('common.quick_actions')"
        class="fixed inset-x-0 bottom-0 z-30 border-t border-border bg-background/90 px-4 pt-3 pb-[max(0.75rem,env(safe-area-inset-bottom))] backdrop-blur-xl lg:hidden"
    >
        <div class="mx-auto flex max-w-md gap-3">
            <a
                :href="phoneHref"
                :class="iconButtonClasses"
                :aria-label="t('common.cta.call')"
            >
                <Phone class="size-4" aria-hidden="true" />
            </a>
            <a
                v-if="whatsappUrl"
                :href="whatsappUrl"
                target="_blank"
                rel="noopener noreferrer"
                :class="iconButtonClasses"
                :aria-label="`${t('common.messaging.whatsapp_action')} ${t('common.messaging.new_tab')}`"
            >
                <WhatsAppIcon class="size-[1.1rem] text-[#25D366]" />
            </a>
            <Link
                :href="quoteUrl()"
                :class="buttonClasses('primary', 'md', 'min-w-0 flex-1')"
            >
                {{ t('common.cta.quote') }}
            </Link>
        </div>
    </aside>
</template>
