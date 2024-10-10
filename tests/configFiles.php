<?php

declare(strict_types=1);

test('config files return all lowercase', function ($files) {
    expect($files)->toReturnLowercase();
})->with(['src/Config/profanities', 'src/Config/tolerated.php']);
