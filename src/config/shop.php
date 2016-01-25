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
            'cart' => [
                'index' => 'cart',
                'product' => 'cart/product'
            ]
        ]
    ],


    'order_status_types' => [
        0 => [
            'title' => 'Prospective'
        ],
        1 => [
            'title' => 'Paid'
        ],
        2 => [
            'title' => 'Processed'
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

    'personalisation_types' => [
        'text',
        'textarea'
    ],

    'shipping' => [
        'rates' => [

        ]

    ],

];
