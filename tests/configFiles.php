<?php

declare(strict_types=1);

test('config files return all lowercase', function () {
    expect('src/Config')->toReturnLowercase()->toReturnUnique();
});
