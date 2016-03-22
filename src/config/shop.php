<?php

return [


    'routes' => [
        'front' => [
            'prefix' => 'shop',
            'category' => [
                'index' => 'categories',
                'show' => 'category/{slug}'
            ],
            'product' => [
                'index' => 'products',
                'show' => 'product/{slug}'
            ],
            'cart' => [
                'prefix' => 'cart',
                'show' => 'cart',
                'item' => 'item',
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


    // TODO: Implement this (return as attribute)
    'stock_status' => [
        [
            'max' => 0,
            'key' => 'none',
            'string' => 'No Stock',
            'color' => '',
        ],
        [
            'max' => 10,
            'key' => 'low',
            'title' => 'Low Stock',
            'color' => '',
        ],
        [
            'max' => null,
            'key' => 'ok',
            'title' => 'Stock OK',
            'color' => '',
        ]
    ],


    // TODO: Implement this (Maybe email?)
    'low_stock_warning' => 10,

    'maxProductCartQuantity' => 99,


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
        'radio' => [
            'view' => 'optionTypeRadio',
        ],
        'select' => [
            'view' => 'optionTypeSelect',
        ],
        'text' => [
            'view' => 'optionTypeText',
        ],
        'textarea' => [
            'view' => 'optionTypeTextarea',
        ]
    ],


    'shipping_tier_property' => 'price',

    'shipping_types' => [
        [
            'id' => 'standard_uk',
            'title' => 'Standard UK',
            'min' => 0,
            'max' => 300,
            'price' => 500
        ],
        [   'id' => 'express_uk',
            'title' => 'Express UK',
            'min' => 0,
            'max' => 300,
            'price' => 1000
        ],
        [   'id' => 'standard_uk_heavy',
            'title' => 'Standard UK Large',
            'min' => 300.01,
            'max' => 5000,
            'price' => 2000
        ],
        [
            'id' => 'express_uk_heavy',
            'title' => 'Express UK Large',
            'min' => 300.01,
            'max' => 5000,
            'price' => 5000
        ],
        [   'id' => 'standard_uk_ridiculous',
            'title' => 'Standard UK Ridiculous',
            'min' => 5005.01,
            'max' => 0,
            'price' => 2000
        ],
        [
            'id' => 'express_uk_ridiculous',
            'title' => 'Express UK Ridiculous',
            'min' => 5001.01,
            'max' => 0,
            'price' => 5000
        ]
    ],

    'countries_allow_billing' => [
        'US',
        'GB'
    ],

    'countries_allow_shipping' => [
        'US',
        'GB'
    ],

    'countries' => [
        'US' => ['name' => 'United States'],
        'GB' => ['name' => 'United Kingdom'],
        'CA' => ['name' => 'Canada'],
        'AU' => ['name' => 'Australia'],
        'FR' => ['name' => 'France'],
        'DE' => ['name' => 'Germany'],
        'IS' => ['name' => 'Iceland'],
        'IE' => ['name' => 'Ireland'],
        'IT' => ['name' => 'Italy'],
        'ES' => ['name' => 'Spain'],
        'SE' => ['name' => 'Sweden'],
        'AT' => ['name' => 'Austria'],
        'BE' => ['name' => 'Belgium'],
        'FI' => ['name' => 'Finland'],
        'CZ' => ['name' => 'Czech Republic'],
        'DK' => ['name' => 'Denmark'],
        'NO' => ['name' => 'Norway'],
        'CH' => ['name' => 'Switzerland'],
        'NZ' => ['name' => 'New Zealand'],
        'RU' => ['name' => 'Russian Federation'],
        'PT' => ['name' => 'Portugal'],
        'NL' => ['name' => 'Netherlands'],
        'IM' => ['name' => 'Isle of Man'],
        'AF' => ['name' => 'Afghanistan'],
        'AX' => ['name' => 'Aland Islands '],
        'AL' => ['name' => 'Albania'],
        'DZ' => ['name' => 'Algeria'],
        'AS' => ['name' => 'American Samoa'],
        'AD' => ['name' => 'Andorra'],
        'AO' => ['name' => 'Angola'],
        'AI' => ['name' => 'Anguilla'],
        'AQ' => ['name' => 'Antarctica'],
        'AG' => ['name' => 'Antigua and Barbuda'],
        'AR' => ['name' => 'Argentina'],
        'AM' => ['name' => 'Armenia'],
        'AW' => ['name' => 'Aruba'],
        'AZ' => ['name' => 'Azerbaijan'],
        'BS' => ['name' => 'Bahamas'],
        'BH' => ['name' => 'Bahrain'],
        'BD' => ['name' => 'Bangladesh'],
        'BB' => ['name' => 'Barbados'],
        'BY' => ['name' => 'Belarus'],
        'BZ' => ['name' => 'Belize'],
        'BJ' => ['name' => 'Benin'],
        'BM' => ['name' => 'Bermuda'],
        'BT' => ['name' => 'Bhutan'],
        'BO' => ['name' => 'Bolivia, Plurinational State of'],
        'BQ' => ['name' => 'Bonaire, Sint Eustatius and Saba'],
        'BA' => ['name' => 'Bosnia and Herzegovina'],
        'BW' => ['name' => 'Botswana'],
        'BV' => ['name' => 'Bouvet Island'],
        'BR' => ['name' => 'Brazil'],
        'IO' => ['name' => 'British Indian Ocean Territory'],
        'BN' => ['name' => 'Brunei Darussalam'],
        'BG' => ['name' => 'Bulgaria'],
        'BF' => ['name' => 'Burkina Faso'],
        'BI' => ['name' => 'Burundi'],
        'KH' => ['name' => 'Cambodia'],
        'CM' => ['name' => 'Cameroon'],
        'CV' => ['name' => 'Cape Verde'],
        'KY' => ['name' => 'Cayman Islands'],
        'CF' => ['name' => 'Central African Republic'],
        'TD' => ['name' => 'Chad'],
        'CL' => ['name' => 'Chile'],
        'CN' => ['name' => 'China'],
        'CX' => ['name' => 'Christmas Island'],
        'CC' => ['name' => 'Cocos (Keeling) Islands'],
        'CO' => ['name' => 'Colombia'],
        'KM' => ['name' => 'Comoros'],
        'CG' => ['name' => 'Congo'],
        'CD' => ['name' => 'Congo, the Democratic Republic of the'],
        'CK' => ['name' => 'Cook Islands' ],
        'CR' => ['name' => 'Costa Rica' ],
        'CI' => ['name' => 'Cote d\'Ivoire' ],
        'HR' => ['name' => 'Croatia' ],
        'CU' => ['name' => 'Cuba' ],
        'CW' => ['name' => 'Curaçao' ],
        'CY' => ['name' => 'Cyprus' ],
        'DJ' => ['name' => 'Djibouti' ],
        'DM' => ['name' => 'Dominica' ],
        'DO' => ['name' => 'Dominican Republic' ],
        'EC' => ['name' => 'Ecuador' ],
        'EG' => ['name' => 'Egypt' ],
        'SV' => ['name' => 'El Salvador' ],
        'GQ' => ['name' => 'Equatorial Guinea' ],
        'ER' => ['name' => 'Eritrea' ],
        'EE' => ['name' => 'Estonia' ],
        'ET' => ['name' => 'Ethiopia' ],
        'FK' => ['name' => 'Falkland Islands (Malvinas)' ],
        'FO' => ['name' => 'Faroe Islands' ],
        'FJ' => ['name' => 'Fiji' ],
        'GF' => ['name' => 'French Guiana' ],
        'PF' => ['name' => 'French Polynesia' ],
        'TF' => ['name' => 'French Southern Territories' ],
        'GA' => ['name' => 'Gabon' ],
        'GM' => ['name' => 'Gambia'],
        'GE' => ['name' => 'Georgia'],
        'GH' => ['name' => 'Ghana'],
        'GI' => ['name' => 'Gibraltar'],
        'GR' => ['name' => 'Greece'],
        'GL' => ['name' => 'Greenland'],
        'GD' => ['name' => 'Grenada'],
        'GP' => ['name' => 'Guadeloupe'],
        'GU' => ['name' => 'Guam'],
        'GT' => ['name' => 'Guatemala'],
        'GG' => ['name' => 'Guernsey'],
        'GN' => ['name' => 'Guinea'],
        'GW' => ['name' => 'Guinea-Bissau'],
        'GY' => ['name' => 'Guyana'],
        'HT' => ['name' => 'Haiti'],
        'HM' => ['name' => 'Heard Island and McDonald Islands'],
        'VA' => ['name' => 'Holy See (Vatican City State)'],
        'HN' => ['name' => 'Honduras'],
        'HK' => ['name' => 'Hong Kong'],
        'HU' => ['name' => 'Hungary'],
        'IN' => ['name' => 'India'],
        'ID' => ['name' => 'Indonesia'],
        'IR' => ['name' => 'Iran, Islamic Republic of'],
        'IQ' => ['name' => 'Iraq'],
        'IL' => ['name' => 'Israel'],
        'JM' => ['name' => 'Jamaica'],
        'JP' => ['name' => 'Japan'],
        'JE' => ['name' => 'Jersey'],
        'JO' => ['name' => 'Jordan'],
        'KZ' => ['name' => 'Kazakhstan'],
        'KE' => ['name' => 'Kenya'],
        'KI' => ['name' => 'Kiribati'],
        'KP' => ['name' => 'Korea, Democratic People\'s Republic of'],
        'KR' => ['name' => 'Korea, Republic of'],
        'KW' => ['name' => 'Kuwait'],
        'KG' => ['name' => 'Kyrgyzstan'],
        'LA' => ['name' => 'Lao People\'s Democratic Republic'],
        'LV' => ['name' => 'Latvia'],
        'LB' => ['name' => 'Lebanon'],
        'LS' => ['name' => 'Lesotho'],
        'LR' => ['name' => 'Liberia'],
        'LY' => ['name' => 'Libyan Arab Jamahiriya'],
        'LI' => ['name' => 'Liechtenstein'],
        'LT' => ['name' => 'Lithuania'],
        'LU' => ['name' => 'Luxembourg'],
        'MO' => ['name' => 'Macao'],
        'MK' => ['name' => 'Macedonia'],
        'MG' => ['name' => 'Madagascar'],
        'MW' => ['name' => 'Malawi'],
        'MY' => ['name' => 'Malaysia'],
        'MV' => ['name' => 'Maldives'],
        'ML' => ['name' => 'Mali'],
        'MT' => ['name' => 'Malta'],
        'MH' => ['name' => 'Marshall Islands'],
        'MQ' => ['name' => 'Martinique'],
        'MR' => ['name' => 'Mauritania'],
        'MU' => ['name' => 'Mauritius'],
        'YT' => ['name' => 'Mayotte'],
        'MX' => ['name' => 'Mexico'],
        'FM' => ['name' => 'Micronesia, Federated States of'],
        'MD' => ['name' => 'Moldova, Republic of'],
        'MC' => ['name' => 'Monaco'],
        'MN' => ['name' => 'Mongolia'],
        'ME' => ['name' => 'Montenegro'],
        'MS' => ['name' => 'Montserrat'],
        'MA' => ['name' => 'Morocco'],
        'MZ' => ['name' => 'Mozambique'],
        'MM' => ['name' => 'Myanmar'],
        'NA' => ['name' => 'Namibia'],
        'NR' => ['name' => 'Nauru'],
        'NP' => ['name' => 'Nepal'],
        'NC' => ['name' => 'New Caledonia'],
        'NI' => ['name' => 'Nicaragua'],
        'NE' => ['name' => 'Niger'],
        'NG' => ['name' => 'Nigeria'],
        'NU' => ['name' => 'Niue'],
        'NF' => ['name' => 'Norfolk Island'],
        'MP' => ['name' => 'Northern Mariana Islands'],
        'OM' => ['name' => 'Oman'],
        'PK' => ['name' => 'Pakistan'],
        'PW' => ['name' => 'Palau'],
        'PS' => ['name' => 'Palestinian Territory, Occupied'],
        'PA' => ['name' => 'Panama'],
        'PG' => ['name' => 'Papua New Guinea'],
        'PY' => ['name' => 'Paraguay'],
        'PE' => ['name' => 'Peru'],
        'PH' => ['name' => 'Philippines'],
        'PN' => ['name' => 'Pitcairn'],
        'PL' => ['name' => 'Poland'],
        'PR' => ['name' => 'Puerto Rico'],
        'QA' => ['name' => 'Qatar'],
        'RE' => ['name' => 'Reunion'],
        'RO' => ['name' => 'Romania'],
        'RW' => ['name' => 'Rwanda'],
        'BL' => ['name' => 'Saint Barthélemy'],
        'SH' => ['name' => 'Saint Helena'],
        'KN' => ['name' => 'Saint Kitts and Nevis'],
        'LC' => ['name' => 'Saint Lucia'],
        'MF' => ['name' => 'Saint Martin (French part)'],
        'PM' => ['name' => 'Saint Pierre and Miquelon'],
        'VC' => ['name' => 'Saint Vincent and the Grenadines'],
        'WS' => ['name' => 'Samoa'],
        'SM' => ['name' => 'San Marino'],
        'ST' => ['name' => 'Sao Tome and Principe'],
        'SA' => ['name' => 'Saudi Arabia'],
        'SN' => ['name' => 'Senegal'],
        'RS' => ['name' => 'Serbia'],
        'SC' => ['name' => 'Seychelles'],
        'SL' => ['name' => 'Sierra Leone'],
        'SG' => ['name' => 'Singapore'],
        'SX' => ['name' => 'Sint Maarten (Dutch part)'],
        'SK' => ['name' => 'Slovakia'],
        'SI' => ['name' => 'Slovenia'],
        'SB' => ['name' => 'Solomon Islands'],
        'SO' => ['name' => 'Somalia'],
        'ZA' => ['name' => 'South Africa'],
        'GS' => ['name' => 'South Georgia and the South Sandwich Islands'],
        'LK' => ['name' => 'Sri Lanka'],
        'SD' => ['name' => 'Sudan'],
        'SR' => ['name' => 'Suriname'],
        'SJ' => ['name' => 'Svalbard and Jan Mayen'],
        'SZ' => ['name' => 'Swaziland'],
        'SY' => ['name' => 'Syrian Arab Republic'],
        'TW' => ['name' => 'Taiwan, Province of China'],
        'TJ' => ['name' => 'Tajikistan'],
        'TZ' => ['name' => 'Tanzania, United Republic of'],
        'TH' => ['name' => 'Thailand'],
        'TL' => ['name' => 'Timor-Leste'],
        'TG' => ['name' => 'Togo'],
        'TK' => ['name' => 'Tokelau'],
        'TO' => ['name' => 'Tonga'],
        'TT' => ['name' => 'Trinidad and Tobago'],
        'TN' => ['name' => 'Tunisia'],
        'TR' => ['name' => 'Turkey'],
        'TM' => ['name' => 'Turkmenistan'],
        'TC' => ['name' => 'Turks and Caicos Islands'],
        'TV' => ['name' => 'Tuvalu'],
        'UG' => ['name' => 'Uganda'],
        'UA' => ['name' => 'Ukraine'],
        'AE' => ['name' => 'United Arab Emirates'],
        'UM' => ['name' => 'United States Minor Outlying Islands'],
        'UY' => ['name' => 'Uruguay'],
        'UZ' => ['name' => 'Uzbekistan'],
        'VU' => ['name' => 'Vanuatu'],
        'VE' => ['name' => 'Venezuela, Bolivarian Republic of'],
        'VN' => ['name' => 'Viet Nam'],
        'VG' => ['name' => 'Virgin Islands, British'],
        'VI' => ['name' => 'Virgin Islands, U.S.'],
        'WF' => ['name' => 'Wallis and Futuna'],
        'EH' => ['name' => 'Western Sahara'],
        'YE' => ['name' => 'Yemen'],
        'ZM' => ['name' => 'Zambia'],
        'ZW' => ['name' => 'Zimbabwe']
    ]

];
