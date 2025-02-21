<?php

declare(strict_types=1);

use JonPurvis\Profanify\Expectations\TargetedProfanity;
use Pest\Arch\Contracts\ArchExpectation;
use Pest\Arch\Support\FileLineFinder;
use PHPUnit\Architecture\Elements\ObjectDescription;

expect()->extend('toHaveNoProfanity', fn (array $excluding = [], array $including = [], $language = null): ArchExpectation => TargetedProfanity::make(
    $this,
    function (ObjectDescription $object) use (&$foundWords, $excluding, $including, $language): bool {
        $words = [];
        $profanitiesDir = __DIR__.'/../Config/profanities';

        if (($profanitiesFiles = scandir($profanitiesDir)) === false) {
            return true;
        }

        $profanitiesFiles = array_diff($profanitiesFiles, ['.', '..']);

        if ($language) {
            $languages = is_string($language) ? [$language] : $language;

            foreach ($languages as $language) {
                $specificLanguage = "$profanitiesDir/$language.php";
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

        $toleratedWords = include __DIR__.'/../Config/tolerated.php';

        $words = array_merge($words, $including);

        $words = array_diff($words, $excluding);

        $fileContents = (string) file_get_contents($object->path);

        foreach ($toleratedWords as $toleratedWord) {
            $fileContents = str_replace($toleratedWord, '', strtolower($fileContents));
        }

        $foundWords = array_filter($words, fn ($word): bool => preg_match('/'.preg_quote($word, '/').'/i', $fileContents) === 1);

        return $foundWords === [];
    },
    function ($path) use (&$foundWords): string {
        return "to have no profanity, but found '".implode(', ', array_values($foundWords ?? []))."'";
    },
    FileLineFinder::where(function (string $line) use (&$foundWords): bool {
        return str_contains(strtolower($line), strtolower((string) array_values($foundWords ?? [])[0]));
    })
));
