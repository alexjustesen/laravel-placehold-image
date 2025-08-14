<?php

declare(strict_types=1);

use AlexJustesen\LaravelPlaceholdImage\PlaceholdImage;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

it('can generate a basic placeholder URL', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage->generate(300, 200);

    expect($url)->toBe('https://placehold.co/300x200.png');
});

it('can generate a square placeholder URL', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage->generate(300);

    expect($url)->toBe('https://placehold.co/300.png');
});

it('can generate URL with background color', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage->generate(300, 200, ['background_color' => 'ff0000']);

    expect($url)->toBe('https://placehold.co/300x200/ff0000.png');
});

it('can generate URL with background and text colors', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage->generate(300, 200, ['background_color' => 'ff0000', 'text_color' => '00ff00']);

    expect($url)->toBe('https://placehold.co/300x200/ff0000/00ff00.png');
});

it('can generate URL with custom text', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage->generate(300, 200, ['text' => 'Hello World']);

    expect($url)->toBe('https://placehold.co/300x200.png?text=Hello+World');
});

it('can generate URL with JPEG format', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage->generate(300, 200, ['format' => 'jpg']);

    expect($url)->toBe('https://placehold.co/300x200.jpg');
});

it('can generate URL with all options', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage->generate(300, 200, [
        'background_color' => 'ff0000',
        'text_color' => '00ff00',
        'format' => 'jpg',
        'text' => 'Test Image',
        'font' => 'arial',
    ]);

    expect($url)->toBe('https://placehold.co/300x200/ff0000/00ff00.jpg?text=Test+Image&font=arial');
});

it('can use fluent interface', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage
        ->format('jpg')
        ->backgroundColor('ff0000')
        ->textColor('00ff00')
        ->text('Fluent')
        ->font('arial')
        ->generate(300, 200);

    expect($url)->toBe('https://placehold.co/300x200/ff0000/00ff00.jpg?text=Fluent&font=arial');
});

it('strips hash from colors', function () {
    $placeholdImage = new PlaceholdImage;
    $url = $placeholdImage
        ->backgroundColor('#ff0000')
        ->textColor('#00ff00')
        ->generate(300, 200);

    expect($url)->toBe('https://placehold.co/300x200/ff0000/00ff00.png');
});

it('throws exception for invalid dimensions', function () {
    $placeholdImage = new PlaceholdImage;

    expect(fn () => $placeholdImage->generate(0))->toThrow(InvalidArgumentException::class);
    expect(fn () => $placeholdImage->generate(-1))->toThrow(InvalidArgumentException::class);
    expect(fn () => $placeholdImage->generate(300, 0))->toThrow(InvalidArgumentException::class);
    expect(fn () => $placeholdImage->generate(300, -1))->toThrow(InvalidArgumentException::class);
});

it('throws exception for oversized dimensions', function () {
    $placeholdImage = new PlaceholdImage;

    expect(fn () => $placeholdImage->generate(4001))->toThrow(InvalidArgumentException::class);
    expect(fn () => $placeholdImage->generate(300, 4001))->toThrow(InvalidArgumentException::class);
});

it('throws exception for invalid format', function () {
    $placeholdImage = new PlaceholdImage;

    expect(fn () => $placeholdImage->format('gif'))->toThrow(InvalidArgumentException::class);
});

it('can download image data', function () {
    $mockHandler = new MockHandler([
        new Response(200, ['Content-Type' => 'image/png'], 'fake-image-data'),
    ]);

    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);

    $placeholdImage = new PlaceholdImage($client);
    $imageData = $placeholdImage->download(300, 200);

    expect($imageData)->toBe('fake-image-data');
});

it('can save image to file', function () {
    $mockHandler = new MockHandler([
        new Response(200, ['Content-Type' => 'image/png'], 'fake-image-data'),
    ]);

    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);

    $placeholdImage = new PlaceholdImage($client);
    $tempFile = tempnam(sys_get_temp_dir(), 'test_image_');

    $result = $placeholdImage->save($tempFile, 300, 200);

    expect($result)->toBeTrue();
    expect(file_get_contents($tempFile))->toBe('fake-image-data');

    unlink($tempFile);
});

it('uses default options from constructor', function () {
    $placeholdImage = new PlaceholdImage(null, [
        'format' => 'jpg',
        'background_color' => 'cccccc',
        'text_color' => '969696',
    ]);

    $url = $placeholdImage->generate(300, 200);

    expect($url)->toBe('https://placehold.co/300x200/cccccc/969696.jpg');
});
