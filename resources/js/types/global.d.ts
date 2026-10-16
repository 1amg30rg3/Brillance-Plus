import type { Directive } from 'vue';
import type { Auth } from '@/types/auth';
import type { BusinessDetails, LocaleCode } from '@/types/site';

declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            locale: LocaleCode;
            translations: Record<string, unknown>;
            business: BusinessDetails;
            agency: { name: string; url: string };
            [key: string]: unknown;
        };
        flashDataType: {
            inquiry?: 'received';
        };
    }
}

declare module 'vue' {
    interface GlobalDirectives {
        vFocus: Directive<HTMLElement, boolean | undefined>;
        vReveal: Directive<HTMLElement, number | undefined>;
    }

    interface ComponentCustomProperties {
        $inertia: typeof Router;
        $page: Page;
        $headManager: ReturnType<typeof createHeadManager>;
    }
}
