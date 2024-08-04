<?php

declare(strict_types=1);

use Pest\Arch\Contracts\ArchExpectation;
use Pest\Arch\Expectations\Targeted;
use Pest\Arch\Support\FileLineFinder;
use PHPUnit\Architecture\Elements\ObjectDescription;

expect()->extend('toHaveNoProfanity', fn (array $excluding = []): ArchExpectation => Targeted::make(
    $this,
    function (ObjectDescription $object) use (&$foundWords, $excluding): bool {
        $words = include __DIR__.'/../Config/words.php';

        $words = array_diff($words, $excluding);

        $fileContents = (string) file_get_contents($object->path);

        $foundWords = array_filter($words, fn ($word): bool => preg_match('/\b'.preg_quote($word, '/').'\b/i', $fileContents) === 1);

        return $foundWords === [];
    },
    'to not use profanity',
    FileLineFinder::where(function (string $line) use (&$foundWords): bool {
        return str_contains($line, (string) array_values($foundWords ?? [])[0]);
    })
));
