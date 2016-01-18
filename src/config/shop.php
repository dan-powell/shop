<?php

return [


    'routes' => [
        'public' => [
            'home' => 'shop',
            'category' => [
                'index' => 'categories',
                'show' => 'category/{slug}'
            ],
            'product' => [
                'index' => 'products',
                'show' => 'product/{slug}'
            ],
        ]
    ],





    'image_types' => [
        'main' => [
            'title' => 'Main'
        ],
        'thumb' => [
            'title' => 'Thumbnail'
        ],
        'hero' => [
            'title' => 'Hero'
        ],
        'gallery' => [
            'title' => 'Gallery'
        ],
    ],

    'option_types' => [
        'radio',
        'select'
    ],

    'personalization_types' => [
        'text',
        'textarea'
    ],

    'shipping' => [
        'rates' => [

        ]

    ],

];
