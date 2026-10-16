import { cn } from '@/lib/utils';

export type ButtonVariant = 'primary' | 'secondary' | 'ghost' | 'light';
export type ButtonSize = 'sm' | 'md' | 'lg';

const variants: Record<ButtonVariant, string> = {
    primary:
        'bg-primary text-primary-foreground shadow-lg shadow-primary/25 hover:-translate-y-0.5 hover:bg-primary-hover hover:shadow-xl hover:shadow-primary/30',
    secondary:
        'border border-border-strong bg-surface text-foreground hover:-translate-y-0.5 hover:border-accent hover:text-accent-strong',
    ghost: 'text-foreground hover:bg-surface-muted',
    light: 'bg-white text-brand-navy shadow-lg shadow-black/20 hover:-translate-y-0.5 hover:bg-sky-50',
};

const sizes: Record<ButtonSize, string> = {
    sm: 'h-10 px-4 text-sm',
    md: 'h-11 px-5 text-sm',
    lg: 'h-12 px-6 text-base',
};

/**
 * Classes for links and buttons styled as buttons.
 */
export function buttonClasses(
    variant: ButtonVariant = 'primary',
    size: ButtonSize = 'md',
    extra?: string,
): string {
    return cn(
        'inline-flex items-center justify-center gap-2 rounded-full font-medium whitespace-nowrap transition duration-200 ease-out active:translate-y-0 active:scale-[0.98] disabled:pointer-events-none disabled:opacity-60',
        variants[variant],
        sizes[size],
        extra,
    );
}
