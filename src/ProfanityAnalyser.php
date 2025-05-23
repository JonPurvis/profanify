<?php

declare(strict_types=1);

namespace Pest\Profanity;

/**
 * @internal
 */
final class ProfanityAnalyser
{
    /**
     * Scan a file for profanity
     *
     * @param  array<string>  $excludingWords
     * @param  array<string>  $includingWords
     * @param  string|array<string>|null  $language
     * @return array<int, Error>
     */
    public static function analyse(string $file, array $excludingWords = [], array $includingWords = [], $language = null): array
    {
        $words = [];
        $profanitiesDir = __DIR__.'/Config/profanities';
        $errors = [];

        if (str_contains($file, '/Config/profanities/')) {
            return [];
        }

        if (($profanitiesFiles = scandir($profanitiesDir)) === false) {
            return [];
        }

        $profanitiesFiles = array_diff($profanitiesFiles, ['.', '..']);

        if ($language) {
            $languages = is_string($language) ? [$language] : $language;

            foreach ($languages as $lang) {
                $specificLanguage = "$profanitiesDir/$lang.php";
                if (file_exists($specificLanguage)) {
                    $words = array_merge(
                        $words,
                        include $specificLanguage
                    );
                }
            }
        } else {
            foreach ($profanitiesFiles as $profanitiesFile) {
                $words = array_merge(
                    $words,
                    include "$profanitiesDir/$profanitiesFile"
                );
            }
        }

        $words = array_merge($words, $includingWords);
        $words = array_diff($words, $excludingWords);

        $fileContents = (string) file_get_contents($file);
        $lines = explode("\n", $fileContents);

        $foundProfanity = [];

        foreach ($words as $word) {
            if (preg_match('/\b'.preg_quote($word, '/').'\b/i', $fileContents) === 1) {
                foreach ($lines as $lineNumber => $line) {
                    $key = $lineNumber.'-'.$word;
                    if (preg_match('/\b'.preg_quote($word, '/').'\b/i', $line) === 1 && ! isset($foundProfanity[$key])) {
                        $errors[] = new Error($file, $lineNumber + 1, $word);
                        $foundProfanity[$key] = true;
                    }
                }
            }
        }

        return $errors;
    }
}
