<?php

declare(strict_types=1);

namespace Pest\Profanity;

use Closure;

/**
 * @internal
 */
final class Analyser
{
    /**
     * Analyse the code for profanity.
     *
     * @param  array<int, string>  $files
     * @param  \Closure(\Pest\Profanity\Result): void  $callback
     * @param  array<string>  $excludingWords
     * @param  array<string>  $includingWords
     * @param  string|array<string>|null  $language
     */
    public static function analyse(
        array $files,
        Closure $callback,
        array $excludingWords = [],
        array $includingWords = [],
        $language = null
    ): void {
        foreach ($files as $file) {
            $errors = ProfanityAnalyser::analyse($file, $excludingWords, $includingWords, $language);
            $callback(new Result($file, $errors));
        }
    }
}
