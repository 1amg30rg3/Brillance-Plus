import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from '@/composables/useI18n';
import type { ServiceKey } from '@/types';

/**
 * The business contact details and configured starting prices.
 */
export function useBusiness() {
    const page = usePage();
    const { formatPrice } = useI18n();

    const business = computed(() => page.props.business);
    const phoneHref = computed(() => `tel:${business.value.phone}`);
    const emailHref = computed(() =>
        business.value.email ? `mailto:${business.value.email}` : null,
    );
    const whatsappUrl = computed(() => business.value.whatsappUrl);
    const messengerUrl = computed(() => business.value.messengerUrl);

    function hourlyPriceFrom(service: ServiceKey): number | null {
        return business.value.hourlyPricesFrom[service] ?? null;
    }

    function formattedHourlyPriceFrom(service: ServiceKey): string | null {
        const price = hourlyPriceFrom(service);

        return price === null ? null : formatPrice(price);
    }

    return {
        business,
        phoneHref,
        emailHref,
        whatsappUrl,
        messengerUrl,
        hourlyPriceFrom,
        formattedHourlyPriceFrom,
    };
}
