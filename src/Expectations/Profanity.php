<?php

declare(strict_types=1);

use Pest\Arch\Contracts\ArchExpectation;
use Pest\Arch\Expectations\Targeted;
use Pest\Arch\Support\FileLineFinder;
use PHPUnit\Architecture\Elements\ObjectDescription;

expect()->extend('toHaveNoProfanity', fn (array $excluding = [], array $including = []): ArchExpectation => Targeted::make(
    $this,
    function (ObjectDescription $object) use (&$foundWords, $excluding, $including): bool {
        $words = array_merge(
            include __DIR__.'/../Config/en.php',
            include __DIR__.'/../Config/it.php',
        );
        
        $toleratedWords = include __DIR__.'/../Config/tolerated.php';

        $words = array_merge($words, $including);

        $words = array_diff($words, $excluding);

        $fileContents = (string) file_get_contents($object->path);

        foreach ($toleratedWords as $toleratedWord) {
            $fileContents = str_replace($toleratedWord, '', $fileContents);
        }

        $foundWords = array_filter($words, fn ($word): bool => preg_match('/'.preg_quote($word, '/').'/i', $fileContents) === 1);

        return $foundWords === [];
    },
    'to not use profanity',
    FileLineFinder::where(function (string $line) use (&$foundWords): bool {
        return str_contains(strtolower($line), strtolower(array_values($foundWords ?? [])[0]));
    })
));
