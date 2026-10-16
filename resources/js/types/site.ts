export type LocaleCode = 'fr' | 'en';

export type SitePageName =
    | 'home'
    | 'services'
    | 'pricing'
    | 'how_it_works'
    | 'about'
    | 'contact'
    | 'privacy_policy'
    | 'legal_notice'
    | 'terms';

export type ServiceKey =
    | 'apartment'
    | 'house'
    | 'kitchen_bathroom'
    | 'regular'
    | 'deep'
    | 'move_in_out';

export type PackageKey = 'essential' | 'comfort' | 'premium';

export type BusinessDetails = {
    name: string;
    phone: string;
    phoneDisplay: string;
    email: string | null;
    whatsappUrl: string | null;
    messengerUrl: string | null;
    currency: string;
    hourlyPricesFrom: Partial<Record<ServiceKey, number>>;
};

export type SeoMetadata = {
    title: string;
    description: string;
    canonical: string;
    alternates: Record<LocaleCode, string>;
    defaultAlternate: string;
    paths: Record<LocaleCode, string>;
    image: string;
    siteName: string;
    openGraphLocale: string;
    openGraphAlternateLocales: string[];
};

export type Option = {
    value: string;
    label: string;
};

export type LegalSection = {
    heading: string;
    paragraphs?: string[];
    list?: string[];
    after?: string[];
};

export type LegalDocumentContent = {
    eyebrow: string;
    relatedTitle: string;
    title: string;
    intro: string;
    updatedAt: string;
    sections: LegalSection[];
};

export type TitledText = {
    title: string;
    text: string;
};

export type InquiryOptions = {
    languages: Option[];
    propertyTypes: Option[];
    services: Option[];
    packages: Option[];
    frequencies: Option[];
    timeSlots: Option[];
};

export type InquiryPrefill = {
    service: string | null;
    package: string | null;
    property_type: string | null;
};
