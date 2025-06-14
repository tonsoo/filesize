<?php

namespace L1nnah\FileSize;

/**
 * Translation helper
 */
class FileSizeTranslatable {
    static function translate(string $key, array $params = [], ?string $locale = null) : string {
        if (function_exists('__')) {
            $translated = __($key, $params, $locale);
            if ($translated !== $key) {
                return $translated;
            }
        }

        $fallbacks = [
            'filesize.decimal-separator' => '.',
            'filesize.thousands-separator' => ',',
        ];

        return $fallbacks[$key] ?? $key;
    }
}