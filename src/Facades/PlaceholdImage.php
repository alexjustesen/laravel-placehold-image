<?php

declare(strict_types=1);

namespace AlexJustesen\LaravelPlaceholdImage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string generate(int $width, ?int $height = null, array $options = [])
 * @method static string download(int $width, ?int $height = null, array $options = [])
 * @method static bool save(string $path, int $width, ?int $height = null, array $options = [])
 * @method static \AlexJustesen\LaravelPlaceholdImage\PlaceholdImage format(string $format)
 * @method static \AlexJustesen\LaravelPlaceholdImage\PlaceholdImage backgroundColor(string $color)
 * @method static \AlexJustesen\LaravelPlaceholdImage\PlaceholdImage textColor(string $color)
 * @method static \AlexJustesen\LaravelPlaceholdImage\PlaceholdImage text(string $text)
 * @method static \AlexJustesen\LaravelPlaceholdImage\PlaceholdImage font(string $font)
 *
 * @see \AlexJustesen\LaravelPlaceholdImage\PlaceholdImage
 */
class PlaceholdImage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AlexJustesen\LaravelPlaceholdImage\PlaceholdImage::class;
    }
}
