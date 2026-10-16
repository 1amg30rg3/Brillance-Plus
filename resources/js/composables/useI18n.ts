import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { LocaleCode } from '@/types';

type Replacements = Record<string, string | number>;

const intlLocales: Record<LocaleCode, string> = {
    fr: 'fr-FR',
    en: 'en-GB',
};

function lookup(source: unknown, key: string): unknown {
    return key
        .split('.')
        .reduce<unknown>(
            (value, segment) =>
                value !== null && typeof value === 'object'
                    ? (value as Record<string, unknown>)[segment]
                    : undefined,
            source,
        );
}

/**
 * Replace Laravel-style `:placeholder` tokens. Longer names are replaced first
 * so that `:apartment` is never mistaken for a shorter `:a` placeholder.
 */
function interpolate(message: string, replacements: Replacements): string {
    return Object.entries(replacements)
        .sort(([first], [second]) => second.length - first.length)
        .reduce(
            (result, [name, value]) =>
                result.replaceAll(`:${name}`, String(value)),
            message,
        );
}

/**
 * Access the translations shared by Laravel (`lang/{locale}/*.php`) and
 * format values for the active locale.
 */
export function useI18n() {
    const page = usePage();

    const locale = computed<LocaleCode>(() => page.props.locale);
    const intlLocale = computed(() => intlLocales[locale.value]);

    /** Translate a string message, e.g. `t('nav.home')`. */
    function t(key: string, replacements: Replacements = {}): string {
        const message = lookup(page.props.translations, key);

        return typeof message === 'string'
            ? interpolate(message, replacements)
            : key;
    }

    /** Get a structured message (a list or a group), e.g. `tm<string[]>('faq.items')`. */
    function tm<T>(key: string): T {
        return lookup(page.props.translations, key) as T;
    }

    function formatPrice(amount: number): string {
        return new Intl.NumberFormat(intlLocale.value, {
            style: 'currency',
            currency: page.props.business.currency,
            maximumFractionDigits: 0,
        }).format(amount);
    }

    return { locale, intlLocale, t, tm, formatPrice };
}
