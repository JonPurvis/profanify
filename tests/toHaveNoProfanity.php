<?php

declare(strict_types=1);

it('passes if a file contains no profanity', function () {
    expect('Tests\Fixtures\HasNoProfanity')
        ->toHaveNoProfanity();
});

it('passes if a file contains profanity but it is excluded', function () {
    expect('Tests\Fixtures\HasProfanityInComment')
        ->toHaveNoProfanity(excluding: ['shit']);
});

it('passes if a file contains capitalised tolerated profanity', function () {
    expect('Tests\Fixtures\HasCapitalisedToleratedProfanity')
        ->toHaveNoProfanity();
});

it('passes if a file contains word starting with tolerated profanity', function () {
    expect('Tests\Fixtures\HasWordStartingWithToleratedProfanity')
        ->toHaveNoProfanity();
});

it('passes if a language is specified and a file contains profanity in another language', function () {
    expect('Tests\Fixtures\HasDifferentLanguageProfanity')
        ->toHaveNoProfanity(language: 'en');
});

it('passes if file does not contain profanity from any specified languages', function () {
    expect('Tests\Fixtures\HasDifferentLanguageProfanity')
        ->toHaveNoProfanity(language: ['en', 'ar']);
});
