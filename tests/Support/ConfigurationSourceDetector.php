<?php

use Pest\Profanity\Support\ConfigurationSourceDetector;

it('detects the source of the application', function () {
    $sources = ConfigurationSourceDetector::detect();

    expect($sources)->toBe([
        realpath(__DIR__.'/../../src'),
        realpath(__DIR__.'/../../tests/Fixtures'),
    ]);
});
