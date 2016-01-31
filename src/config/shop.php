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
                'item' => 'cart/item',
                'clearproduct' => 'cart/clearproduct/{id}',
                'clear' => 'cart/clear'
            ],
            'order' => [
                'create' => 'order/create',
                'store' => 'order/store',
                'confirm' => 'order/confirm'
            ]
        ]
    ],


    'currency' => [
        'code' => 'GBP',
        'symbol' => '£'
    ],

    'units' => [
        'weight' => 'kg',
        'width' => 'cm',
        'height' => 'cm',
        'length' => 'cm'
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
        'select',
        'text',
        'textarea'
    ],


    'shipping_tier_property' => 'price',

    'shipping_types' => [
        'standard_uk' => [
            'title' => 'Standard UK',
            'min' => '0',
            'max' => '300',
            'price' => 500
        ],
        'express_uk' => [
            'title' => 'Express UK',
            'min' => '0',
            'max' => '300',
            'price' => 1000
        ],
        'standard_uk_heavy' => [
            'title' => 'Standard UK Large',
            'min' => '300.00001',
            'max' => '9000000000',
            'price' => 2000
        ],
        'express_uk_heavy' => [
            'title' => 'Express UK Large',
            'min' => '300.00001',
            'max' => '9000000000',
            'price' => 5000
        ]
    ],

];
