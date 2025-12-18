<?php

namespace App\Services;

class PortfolioCache
{
    /**
     * Clear cached portfolio fragments.
     *
     * @param array<int, string>|null $keys
     */
    public static function clear(?array $keys = null): void
    {
        $cache = cache();
        $keys ??= [
            CacheKeys::HOMEPAGE_DATA,
            CacheKeys::CONTACT_DETAILS,
            CacheKeys::FRONTEND_ACTIVITY,
        ];

        foreach ($keys as $key) {
            $cache->delete($key);
        }
    }
}

