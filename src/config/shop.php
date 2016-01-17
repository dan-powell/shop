<?php

return [


    'routes' => [
        'public' => [
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
        'main',
        'thumb',
        'hero',
        'gallery'
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
