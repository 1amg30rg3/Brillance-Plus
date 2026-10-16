<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Menu, X } from '@lucide/vue';
import {
    computed,
    nextTick,
    onBeforeUnmount,
    onMounted,
    ref,
    watch,
} from 'vue';
import AppLogo from '@/components/brand/AppLogo.vue';
import ContactChannelLinks from '@/components/contact/ContactChannelLinks.vue';
import LanguageSwitcher from '@/components/layout/LanguageSwitcher.vue';
import ThemeSwitcher from '@/components/layout/ThemeSwitcher.vue';
import { useI18n } from '@/composables/useI18n';
import { useSiteRoutes } from '@/composables/useSiteRoutes';
import { buttonClasses } from '@/lib/button';
import type { SitePageName } from '@/types';

const { t } = useI18n();
const { pageUrl, quoteUrl, isCurrent } = useSiteRoutes();

const navigation = computed<{ name: SitePageName; label: string }[]>(() => [
    { name: 'home', label: t('nav.home') },
    { name: 'services', label: t('nav.services') },
    { name: 'pricing', label: t('nav.pricing') },
    { name: 'how_it_works', label: t('nav.how_it_works') },
    { name: 'about', label: t('nav.about') },
    { name: 'contact', label: t('nav.contact') },
]);

const header = ref<HTMLElement | null>(null);
const menuToggle = ref<HTMLButtonElement | null>(null);
const menuPanel = ref<HTMLElement | null>(null);
const isMenuOpen = ref(false);
const isScrolled = ref(false);

function openMenu(): void {
    isMenuOpen.value = true;
}

function closeMenu(returnFocus = false): void {
    isMenuOpen.value = false;

    if (returnFocus) {
        menuToggle.value?.focus();
    }
}

/** Keep keyboard focus inside the header while the mobile menu is open. */
function trapFocus(event: KeyboardEvent): void {
    if (!isMenuOpen.value || event.key !== 'Tab' || !header.value) {
        return;
    }

    const focusable = [
        ...header.value.querySelectorAll<HTMLElement>(
            'a[href], button:not([disabled]), input:not([disabled])',
        ),
    ].filter((element) => element.offsetParent !== null);

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last?.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first?.focus();
    }
}

watch(isMenuOpen, async (isOpen) => {
    document.documentElement.classList.toggle('overflow-hidden', isOpen);

    if (isOpen) {
        await nextTick();
        menuPanel.value?.querySelector<HTMLElement>('a[href]')?.focus();
    }
});

function onScroll(): void {
    isScrolled.value = window.scrollY > 8;
}

const desktopQuery = ref<MediaQueryList | null>(null);

function onDesktopChange(event: MediaQueryListEvent): void {
    if (event.matches) {
        closeMenu();
    }
}

let removeNavigateListener: (() => void) | null = null;

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    desktopQuery.value = window.matchMedia('(min-width: 80rem)');
    desktopQuery.value.addEventListener('change', onDesktopChange);

    removeNavigateListener = router.on('navigate', () => closeMenu());
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    desktopQuery.value?.removeEventListener('change', onDesktopChange);
    removeNavigateListener?.();
    document.documentElement.classList.remove('overflow-hidden');
});
</script>

<template>
    <header
        ref="header"
        class="sticky top-0 z-40 border-b transition-[background-color,border-color,box-shadow] duration-300"
        :class="
            isMenuOpen
                ? 'border-border bg-background'
                : isScrolled
                  ? 'border-border/80 bg-background/85 shadow-sm shadow-black/[0.03] backdrop-blur-xl'
                  : 'border-transparent bg-transparent'
        "
        @keydown="trapFocus"
        @keydown.esc="isMenuOpen && closeMenu(true)"
    >
        <!-- No backdrop blur while the menu is open: backdrop-filter would become the containing block of the fixed menu panel. -->
        <div
            class="container-site flex h-18 items-center justify-between gap-4"
        >
            <Link
                :href="pageUrl('home')"
                class="rounded-xl"
                :aria-label="t('common.home_link')"
            >
                <AppLogo />
            </Link>

            <nav :aria-label="t('nav.label')" class="hidden xl:block">
                <ul class="flex items-center gap-1">
                    <li v-for="item in navigation" :key="item.name">
                        <Link
                            :href="pageUrl(item.name)"
                            :aria-current="
                                isCurrent(item.name) ? 'page' : undefined
                            "
                            prefetch
                            class="group relative inline-flex rounded-full px-3.5 py-2 text-sm font-medium transition-colors"
                            :class="
                                isCurrent(item.name)
                                    ? 'text-foreground'
                                    : 'text-foreground-muted hover:text-foreground'
                            "
                        >
                            {{ item.label }}
                            <span
                                aria-hidden="true"
                                class="absolute inset-x-3.5 bottom-0.5 h-0.5 origin-left rounded-full bg-accent transition-transform duration-300"
                                :class="
                                    isCurrent(item.name)
                                        ? 'scale-x-100'
                                        : 'scale-x-0 group-hover:scale-x-100'
                                "
                            />
                        </Link>
                    </li>
                </ul>
            </nav>

            <div class="flex items-center gap-2">
                <LanguageSwitcher class="hidden sm:block" />
                <ThemeSwitcher
                    variant="compact"
                    class="hidden sm:inline-block"
                />
                <Link
                    v-if="!isCurrent('contact')"
                    :href="quoteUrl()"
                    :class="
                        buttonClasses(
                            'primary',
                            'md',
                            'ml-1 hidden lg:inline-flex',
                        )
                    "
                >
                    {{ t('common.cta.quote') }}
                </Link>
                <button
                    ref="menuToggle"
                    type="button"
                    class="grid size-11 place-items-center rounded-full border border-border bg-surface text-foreground transition hover:border-accent xl:hidden"
                    :aria-label="
                        isMenuOpen
                            ? t('common.menu.close')
                            : t('common.menu.open')
                    "
                    :aria-expanded="isMenuOpen"
                    aria-controls="mobile-menu"
                    @click="isMenuOpen ? closeMenu() : openMenu()"
                >
                    <X v-if="isMenuOpen" class="size-5" aria-hidden="true" />
                    <Menu v-else class="size-5" aria-hidden="true" />
                </button>
            </div>
        </div>

        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="-translate-y-2 opacity-0"
            leave-active-class="transition duration-200 ease-in"
            leave-to-class="-translate-y-2 opacity-0"
        >
            <div
                v-show="isMenuOpen"
                id="mobile-menu"
                ref="menuPanel"
                class="fixed inset-x-0 top-18 bottom-0 z-40 overflow-y-auto border-t border-border bg-background xl:hidden"
            >
                <div class="container-site flex min-h-full flex-col gap-8 py-8">
                    <nav :aria-label="t('nav.label')">
                        <ul class="flex flex-col">
                            <li
                                v-for="(item, index) in navigation"
                                :key="item.name"
                                class="border-b border-border/70"
                            >
                                <Link
                                    :href="pageUrl(item.name)"
                                    :aria-current="
                                        isCurrent(item.name)
                                            ? 'page'
                                            : undefined
                                    "
                                    class="flex items-center justify-between py-4 font-display text-2xl transition-colors motion-safe:animate-fade-up"
                                    :class="
                                        isCurrent(item.name)
                                            ? 'text-accent-strong'
                                            : 'text-foreground hover:text-accent-strong'
                                    "
                                    :style="{
                                        animationDelay: `${index * 45}ms`,
                                    }"
                                >
                                    {{ item.label }}
                                    <span
                                        v-if="isCurrent(item.name)"
                                        aria-hidden="true"
                                        class="size-2 rounded-full bg-accent"
                                    />
                                </Link>
                            </li>
                        </ul>
                    </nav>

                    <div class="flex flex-col gap-4">
                        <Link
                            v-if="!isCurrent('contact')"
                            :href="quoteUrl()"
                            :class="
                                buttonClasses(
                                    'primary',
                                    'lg',
                                    'w-full sm:w-auto sm:self-start',
                                )
                            "
                        >
                            {{ t('common.cta.quote') }}
                        </Link>
                        <ContactChannelLinks />
                    </div>

                    <div
                        class="mt-auto flex flex-wrap items-center justify-between gap-4 border-t border-border pt-6"
                    >
                        <LanguageSwitcher />
                        <ThemeSwitcher />
                    </div>
                </div>
            </div>
        </Transition>
    </header>
</template>
