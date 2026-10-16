<?php

namespace App\Support;

/**
 * Builds the WhatsApp and Messenger links from the configured business details.
 *
 * A channel that is not configured, or configured with an unusable value,
 * returns null so the website never displays a broken link.
 */
class MessagingLinks
{
    /**
     * A wa.me link opening a chat with the business, pre-filled with a greeting.
     */
    public function whatsapp(string $greeting): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) config('business.whatsapp'));

        if ($digits === null || strlen($digits) < 8) {
            return null;
        }

        return "https://wa.me/{$digits}?text=".rawurlencode($greeting);
    }

    /**
     * An m.me link opening a Messenger chat with the business.
     *
     * Accepts a username, an m.me / messenger.com link, or a Facebook page or
     * profile address (facebook.com/{username} or facebook.com/profile.php?id=…).
     */
    public function messenger(): ?string
    {
        $value = trim((string) config('business.messenger'));

        if ($value === '') {
            return null;
        }

        if (! str_starts_with($value, 'https://')) {
            return $this->messengerLinkFor(ltrim($value, '@'));
        }

        $host = (string) parse_url($value, PHP_URL_HOST);

        if (in_array($host, ['m.me', 'messenger.com', 'www.messenger.com'], true)) {
            return $value;
        }

        if (in_array($host, ['facebook.com', 'www.facebook.com', 'm.facebook.com'], true)) {
            return $this->messengerLinkFor($this->facebookAccount($value));
        }

        return null;
    }

    /**
     * The account a Facebook profile or page address points to.
     *
     * Conversation addresses (facebook.com/messages/…) belong to their owner's
     * inbox and cannot be opened by visitors, so they are rejected.
     */
    private function facebookAccount(string $url): ?string
    {
        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');

        if ($path === 'profile.php') {
            parse_str((string) parse_url($url, PHP_URL_QUERY), $query);

            return is_string($query['id'] ?? null) ? $query['id'] : null;
        }

        $reservedPaths = ['', 'messages', 'groups', 'events', 'watch', 'marketplace', 'share', 'sharer.php', 'home.php'];

        return str_contains($path, '/') || in_array($path, $reservedPaths, true) ? null : $path;
    }

    private function messengerLinkFor(?string $account): ?string
    {
        return $account !== null && preg_match('/^[A-Za-z0-9.]{3,50}$/', $account) === 1
            ? "https://m.me/{$account}"
            : null;
    }
}
