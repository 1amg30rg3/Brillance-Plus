import type { Directive } from 'vue';

let observer: IntersectionObserver | null = null;

function revealObserver(): IntersectionObserver {
    observer ??= new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer?.unobserve(entry.target);
                }
            }
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.12 },
    );

    return observer;
}

/**
 * Fade and slide an element in when it scrolls into view: `v-reveal` or `v-reveal="150"` (delay in ms).
 *
 * Elements already on screen, browsers without IntersectionObserver and
 * visitors who prefer reduced motion get no animation, so content is never hidden.
 */
export const vReveal: Directive<HTMLElement, number | undefined> = {
    getSSRProps: () => ({}),
    mounted(element, binding) {
        if (
            !('IntersectionObserver' in window) ||
            window.matchMedia('(prefers-reduced-motion: reduce)').matches ||
            element.getBoundingClientRect().top < window.innerHeight * 0.9
        ) {
            return;
        }

        if (binding.value) {
            element.style.setProperty('--reveal-delay', `${binding.value}ms`);
        }

        element.classList.add('reveal');
        revealObserver().observe(element);
    },
    unmounted(element) {
        observer?.unobserve(element);
    },
};
