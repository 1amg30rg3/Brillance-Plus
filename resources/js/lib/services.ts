import {
    Bath,
    Building,
    CalendarCheck,
    House,
    KeyRound,
    Sparkles,
} from '@lucide/vue';
import type { Component } from 'vue';
import type { PackageKey, ServiceKey } from '@/types';

export type ServiceVisual = {
    key: ServiceKey;
    icon: Component;
    image: string;
};

/**
 * The cleaning services, in display order, with their icon and photo.
 * Texts live in `lang/{locale}/services.php`.
 */
export const services: ServiceVisual[] = [
    { key: 'apartment', icon: Building, image: 'service-apartment' },
    { key: 'house', icon: House, image: 'service-house' },
    { key: 'kitchen_bathroom', icon: Bath, image: 'service-kitchen-bathroom' },
    { key: 'regular', icon: CalendarCheck, image: 'service-regular' },
    { key: 'deep', icon: Sparkles, image: 'service-deep' },
    { key: 'move_in_out', icon: KeyRound, image: 'service-move' },
];

export const packages: PackageKey[] = ['essential', 'comfort', 'premium'];

export const recommendedPackage: PackageKey = 'comfort';

/** Responsive `srcset` for a photo exported at the given widths (`/images/{name}-{width}.webp`). */
export function imageSrcset(name: string, widths: number[]): string {
    return widths
        .map((width) => `/images/${name}-${width}.webp ${width}w`)
        .join(', ');
}
