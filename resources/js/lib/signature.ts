let isPrinted = false;

/**
 * Sign the browser console for developers who inspect the website.
 */
export function printSignature(agency: { name: string; url: string }): void {
    if (isPrinted) {
        return;
    }

    isPrinted = true;

    const url = new URL(agency.url);
    url.search = new URLSearchParams({
        utm_source: 'brillance-plus.fr',
        utm_medium: 'console',
        utm_campaign: 'site-credit',
    }).toString();

    console.info(
        `%c ${agency.name} %c Designed & built by ${agency.name}: custom websites and web apps, however complex.\n%c→ ${url.toString()}`,
        'background:#ff6a5b;color:#fff;font-weight:700;border-radius:999px;padding:3px 8px;',
        'font-weight:500;',
        'color:#ff6a5b;font-weight:600;',
    );
}
