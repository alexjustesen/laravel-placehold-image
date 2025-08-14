# 🖼️ Laravel Placehold Image

A Laravel package to generate placeholder images from https://placehold.co/.

## Installation

You can install the package via composer:

```bash
composer require alexjustesen/laravel-placehold-image
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-placehold-image-config"
```

This is the contents of the published config file:

```php
return [
    'defaults' => [
        'format' => 'png',
        'background_color' => null,
        'text_color' => null,
        'text' => null,
        'font' => null,
    ],
];
```

## Usage

### Basic Usage

Generate a placeholder image URL:

```php
use AlexJustesen\LaravelPlaceholdImage\Facades\PlaceholdImage;

// Generate a 300x200 image
$url = PlaceholdImage::generate(300, 200);
// Returns: https://placehold.co/300x200

// Generate a square 300x300 image
$url = PlaceholdImage::generate(300);
// Returns: https://placehold.co/300
```

### Customization Options

You can customize the placeholder image with various options:

```php
// With background color
$url = PlaceholdImage::generate(300, 200, ['background_color' => 'ff0000']);
// Returns: https://placehold.co/300x200/ff0000

// With background and text colors
$url = PlaceholdImage::generate(300, 200, [
    'background_color' => 'ff0000',
    'text_color' => '00ff00'
]);
// Returns: https://placehold.co/300x200/ff0000/00ff00

// With custom text
$url = PlaceholdImage::generate(300, 200, ['text' => 'Hello World']);
// Returns: https://placehold.co/300x200?text=Hello+World

// With different format
$url = PlaceholdImage::generate(300, 200, ['format' => 'jpg']);
// Returns: https://placehold.co/300x200.jpg
```

### Fluent Interface

The package supports a fluent interface for method chaining:

```php
$url = PlaceholdImage::format('jpg')
    ->backgroundColor('ff0000')
    ->textColor('ffffff')
    ->text('Custom Text')
    ->font('arial')
    ->generate(300, 200);
// Returns: https://placehold.co/300x200/ff0000/ffffff.jpg?text=Custom+Text&font=arial
```

### Downloading Images

You can download the image data directly:

```php
// Download image data as string
$imageData = PlaceholdImage::download(300, 200);

// Save image to file
$success = PlaceholdImage::save('/path/to/image.png', 300, 200);
```

### Using Dependency Injection

You can also inject the service directly:

```php
use AlexJustesen\LaravelPlaceholdImage\PlaceholdImage;

class ImageController extends Controller
{
    public function view()
    {
        $url = PlaceholdImage::generate(300, 200);

        return response()->json(['url' => $url]);
    }
}
```

### Available Methods

#### `generate(int $width, ?int $height = null, array $options = []): string`
Generates a placeholder image URL.

#### `download(int $width, ?int $height = null, array $options = []): string`
Downloads the image data as a string.

#### `save(string $path, int $width, ?int $height = null, array $options = []): bool`
Saves the image to a file path.

#### Fluent Methods
- `format(string $format)` - Set format (png, jpg, jpeg, webp)
- `backgroundColor(string $color)` - Set background color (hex without #)
- `textColor(string $color)` - Set text color (hex without #)
- `text(string $text)` - Set custom text
- `font(string $font)` - Set font family

### Configuration

You can set default options in the config file that will be applied to all requests:

```php
// config/placehold-image.php
return [
    'defaults' => [
        'format' => 'jpg',
        'background_color' => 'cccccc',
        'text_color' => '969696',
        'text' => null,
        'font' => 'arial',
    ],
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Alex Justesen](https://github.com/alexjustesen)
- [All Contributors](https://github.com/alexjustesen/laravel-placehold-image/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
