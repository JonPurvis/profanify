<?php

declare(strict_types=1);

use Pest\Arch\Exceptions\ArchExpectationFailedException;

it('fails if a file contains profanity in a comment', function () {
    expect('Tests\Fixtures\HasProfanityInComment')
        ->toHaveNoProfanity();
})->throws(ArchExpectationFailedException::class);

it('fails if a file contains profanity in a method', function () {
    expect('Tests\Fixtures\HasProfanityInMethod')
        ->toHaveNoProfanity();
})->throws(ArchExpectationFailedException::class);

it('fails if a file contains profanity in a property', function () {
    expect('Tests\Fixtures\HasProfanityInProperty')
        ->toHaveNoProfanity();
})->throws(ArchExpectationFailedException::class);
