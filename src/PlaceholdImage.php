<?php

declare(strict_types=1);

namespace AlexJustesen\LaravelPlaceholdImage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class PlaceholdImage
{
    private Client $client;

    private string $baseUrl = 'https://placehold.co';

    private array $defaultOptions;

    public function __construct(?Client $client = null, array $defaultOptions = [])
    {
        $this->client = $client ?? new Client;
        $this->defaultOptions = array_merge([
            'format' => 'png',
            'background_color' => null,
            'text_color' => null,
            'text' => null,
            'font' => null,
        ], $defaultOptions);
    }

    public function generate(int $width, ?int $height = null, array $options = []): string
    {
        $this->validateDimensions($width, $height);

        $options = array_merge($this->defaultOptions, $options);
        $dimensions = $height ? "{$width}x{$height}" : (string) $width;

        $url = $this->buildUrl($dimensions, $options);

        return $url;
    }

    public function download(int $width, ?int $height = null, array $options = []): string
    {
        $url = $this->generate($width, $height, $options);

        try {
            $response = $this->client->get($url);

            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new InvalidArgumentException("Failed to download image: {$e->getMessage()}", 0, $e);
        }
    }

    public function save(string $path, int $width, ?int $height = null, array $options = []): bool
    {
        $imageData = $this->download($width, $height, $options);

        return file_put_contents($path, $imageData) !== false;
    }

    public function format(string $format): self
    {
        if (! in_array($format, ['png', 'jpg', 'jpeg', 'webp'])) {
            throw new InvalidArgumentException("Unsupported format: {$format}");
        }

        $this->defaultOptions['format'] = $format;

        return $this;
    }

    public function backgroundColor(string $color): self
    {
        $this->defaultOptions['background_color'] = ltrim($color, '#');

        return $this;
    }

    public function textColor(string $color): self
    {
        $this->defaultOptions['text_color'] = ltrim($color, '#');

        return $this;
    }

    public function text(string $text): self
    {
        $this->defaultOptions['text'] = $text;

        return $this;
    }

    public function font(string $font): self
    {
        $this->defaultOptions['font'] = $font;

        return $this;
    }

    private function validateDimensions(int $width, ?int $height = null): void
    {
        if ($width <= 0 || ($height !== null && $height <= 0)) {
            throw new InvalidArgumentException('Width and height must be positive integers');
        }

        if ($width > 4000 || ($height !== null && $height > 4000)) {
            throw new InvalidArgumentException('Width and height must not exceed 4000px');
        }
    }

    private function buildUrl(string $dimensions, array $options): string
    {
        $url = "{$this->baseUrl}/{$dimensions}";

        if ($options['background_color'] && $options['text_color']) {
            $url .= "/{$options['background_color']}/{$options['text_color']}";
        } elseif ($options['background_color']) {
            $url .= "/{$options['background_color']}";
        }

        if ($options['format'] && $options['format'] !== 'png') {
            $url .= ".{$options['format']}";
        }

        $queryParams = [];

        if ($options['text']) {
            $queryParams['text'] = $options['text'];
        }

        if ($options['font']) {
            $queryParams['font'] = $options['font'];
        }

        if (! empty($queryParams)) {
            $url .= '?'.http_build_query($queryParams);
        }

        return $url;
    }
}
