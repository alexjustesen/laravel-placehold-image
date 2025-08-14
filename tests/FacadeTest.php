<?php

declare(strict_types=1);

use AlexJustesen\LaravelPlaceholdImage\Facades\PlaceholdImage;

it('can use facade to generate URLs', function () {
    $url = PlaceholdImage::generate(300, 200);

    expect($url)->toBe('https://placehold.co/300x200.png');
});

it('can use fluent interface through facade', function () {
    $url = PlaceholdImage::format('jpg')
        ->backgroundColor('ff0000')
        ->textColor('00ff00')
        ->generate(300, 200);

    expect($url)->toBe('https://placehold.co/300x200/ff0000/00ff00.jpg');
});
