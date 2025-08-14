<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Default options that will be applied to all placeholder image requests.
    | You can override these options when calling the generate method.
    |
    */

    'defaults' => [

        /*
        |--------------------------------------------------------------------------
        | Format
        |--------------------------------------------------------------------------
        |
        | The default image format. Supported formats: png, jpg, jpeg, webp
        |
        */

        'format' => 'png',

        /*
        |--------------------------------------------------------------------------
        | Background Color
        |--------------------------------------------------------------------------
        |
        | The default background color for the placeholder image.
        | Should be a hex color without the # prefix (e.g., 'cccccc').
        |
        */

        'background_color' => null,

        /*
        |--------------------------------------------------------------------------
        | Text Color
        |--------------------------------------------------------------------------
        |
        | The default text color for the placeholder image.
        | Should be a hex color without the # prefix (e.g., '969696').
        |
        */

        'text_color' => null,

        /*
        |--------------------------------------------------------------------------
        | Text
        |--------------------------------------------------------------------------
        |
        | The default text to display on the placeholder image.
        | If null, the dimensions will be displayed.
        |
        */

        'text' => null,

        /*
        |--------------------------------------------------------------------------
        | Font
        |--------------------------------------------------------------------------
        |
        | The default font family to use for the text.
        | Supported fonts depend on placehold.co service.
        |
        */

        'font' => null,

    ],

];
