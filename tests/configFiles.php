<?php

declare(strict_types=1);

test('config files return lowercase and unique values', function () {
    expect('src/Config')->toReturnLowercase()->toReturnUnique();
});
