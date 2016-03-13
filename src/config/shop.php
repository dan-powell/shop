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


    'shipping_tier_property' => 'weight',

    'shipping_types' => [
        [
            'id' => 'standard_uk',
            'title' => 'Standard UK',
            'min' => '0',
            'max' => '300',
            'price' => 500
        ],
        [   'id' => 'express_uk',
            'title' => 'Express UK',
            'min' => '0',
            'max' => '300',
            'price' => 1000
        ],
        [   'id' => 'standard_uk_heavy',
            'title' => 'Standard UK Large',
            'min' => '300.00001',
            'max' => '9000000000',
            'price' => 2000
        ],
        [
            'id' => 'express_uk_heavy',
            'title' => 'Express UK Large',
            'min' => '300.00001',
            'max' => '9000000000',
            'price' => 5000
        ]
    ],

    'countries' => [
        [ 'code' => 'US', 'name' => 'United States', 'allow_shipping' => true, 'allow_billing' => true],
        [ 'code' => 'GB', 'name' => 'United Kingdom', 'allow_shipping' => true, 'allow_billing' => true],
        [ 'code' => 'CA', 'name' => 'Canada', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AU', 'name' => 'Australia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'FR', 'name' => 'France', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'DE', 'name' => 'Germany', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IS', 'name' => 'Iceland', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IE', 'name' => 'Ireland', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IT', 'name' => 'Italy', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'ES', 'name' => 'Spain', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SE', 'name' => 'Sweden', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AT', 'name' => 'Austria', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BE', 'name' => 'Belgium', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'FI', 'name' => 'Finland', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CZ', 'name' => 'Czech Republic', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'DK', 'name' => 'Denmark', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NO', 'name' => 'Norway', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CH', 'name' => 'Switzerland', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NZ', 'name' => 'New Zealand', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'RU', 'name' => 'Russian Federation', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PT', 'name' => 'Portugal', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NL', 'name' => 'Netherlands', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IM', 'name' => 'Isle of Man', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AF', 'name' => 'Afghanistan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AX', 'name' => 'Aland Islands ', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AL', 'name' => 'Albania', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'DZ', 'name' => 'Algeria', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AS', 'name' => 'American Samoa', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AD', 'name' => 'Andorra', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AO', 'name' => 'Angola', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AI', 'name' => 'Anguilla', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AQ', 'name' => 'Antarctica', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AG', 'name' => 'Antigua and Barbuda', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AR', 'name' => 'Argentina', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AM', 'name' => 'Armenia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AW', 'name' => 'Aruba', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AZ', 'name' => 'Azerbaijan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BS', 'name' => 'Bahamas', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BH', 'name' => 'Bahrain', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BD', 'name' => 'Bangladesh', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BB', 'name' => 'Barbados', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BY', 'name' => 'Belarus', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BZ', 'name' => 'Belize', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BJ', 'name' => 'Benin', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BM', 'name' => 'Bermuda', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BT', 'name' => 'Bhutan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BO', 'name' => 'Bolivia, Plurinational State of', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BQ', 'name' => 'Bonaire, Sint Eustatius and Saba', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BA', 'name' => 'Bosnia and Herzegovina', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BW', 'name' => 'Botswana', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BV', 'name' => 'Bouvet Island', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BR', 'name' => 'Brazil', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IO', 'name' => 'British Indian Ocean Territory', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BN', 'name' => 'Brunei Darussalam', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BG', 'name' => 'Bulgaria', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BF', 'name' => 'Burkina Faso', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BI', 'name' => 'Burundi', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KH', 'name' => 'Cambodia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CM', 'name' => 'Cameroon', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CV', 'name' => 'Cape Verde', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KY', 'name' => 'Cayman Islands', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CF', 'name' => 'Central African Republic', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TD', 'name' => 'Chad', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CL', 'name' => 'Chile', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CN', 'name' => 'China', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CX', 'name' => 'Christmas Island', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CC', 'name' => 'Cocos (Keeling) Islands', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CO', 'name' => 'Colombia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KM', 'name' => 'Comoros', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CG', 'name' => 'Congo', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CD', 'name' => 'Congo, the Democratic Republic of the', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'CK', 'name' => 'Cook Islands', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'CR', 'name' => 'Costa Rica', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'CI', 'name' => 'Cote d\'Ivoire', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'HR', 'name' => 'Croatia', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'CU', 'name' => 'Cuba', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'CW', 'name' => 'Curaçao', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'CY', 'name' => 'Cyprus', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'DJ', 'name' => 'Djibouti', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'DM', 'name' => 'Dominica', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'DO', 'name' => 'Dominican Republic', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'EC', 'name' => 'Ecuador', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'EG', 'name' => 'Egypt', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'SV', 'name' => 'El Salvador', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'GQ', 'name' => 'Equatorial Guinea', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'ER', 'name' => 'Eritrea', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'EE', 'name' => 'Estonia', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'ET', 'name' => 'Ethiopia', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'FK', 'name' => 'Falkland Islands (Malvinas)', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'FO', 'name' => 'Faroe Islands', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'FJ', 'name' => 'Fiji', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'GF', 'name' => 'French Guiana', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'PF', 'name' => 'French Polynesia', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'TF', 'name' => 'French Southern Territories', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'GA', 'name' => 'Gabon', 'allow_shipping' => false, 'allow_billing' => false ],
        [ 'code' => 'GM', 'name' => 'Gambia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GE', 'name' => 'Georgia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GH', 'name' => 'Ghana', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GI', 'name' => 'Gibraltar', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GR', 'name' => 'Greece', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GL', 'name' => 'Greenland', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GD', 'name' => 'Grenada', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GP', 'name' => 'Guadeloupe', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GU', 'name' => 'Guam', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GT', 'name' => 'Guatemala', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GG', 'name' => 'Guernsey', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GN', 'name' => 'Guinea', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GW', 'name' => 'Guinea-Bissau', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GY', 'name' => 'Guyana', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'HT', 'name' => 'Haiti', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'HM', 'name' => 'Heard Island and McDonald Islands', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'VA', 'name' => 'Holy See (Vatican City State)', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'HN', 'name' => 'Honduras', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'HK', 'name' => 'Hong Kong', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'HU', 'name' => 'Hungary', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IN', 'name' => 'India', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'ID', 'name' => 'Indonesia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IR', 'name' => 'Iran, Islamic Republic of', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IQ', 'name' => 'Iraq', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'IL', 'name' => 'Israel', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'JM', 'name' => 'Jamaica', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'JP', 'name' => 'Japan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'JE', 'name' => 'Jersey', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'JO', 'name' => 'Jordan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KZ', 'name' => 'Kazakhstan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KE', 'name' => 'Kenya', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KI', 'name' => 'Kiribati', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KP', 'name' => 'Korea, Democratic People\'s Republic of', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KR', 'name' => 'Korea, Republic of', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KW', 'name' => 'Kuwait', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KG', 'name' => 'Kyrgyzstan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LA', 'name' => 'Lao People\'s Democratic Republic', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LV', 'name' => 'Latvia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LB', 'name' => 'Lebanon', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LS', 'name' => 'Lesotho', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LR', 'name' => 'Liberia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LY', 'name' => 'Libyan Arab Jamahiriya', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LI', 'name' => 'Liechtenstein', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LT', 'name' => 'Lithuania', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LU', 'name' => 'Luxembourg', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MO', 'name' => 'Macao', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MK', 'name' => 'Macedonia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MG', 'name' => 'Madagascar', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MW', 'name' => 'Malawi', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MY', 'name' => 'Malaysia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MV', 'name' => 'Maldives', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'ML', 'name' => 'Mali', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MT', 'name' => 'Malta',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MH', 'name' => 'Marshall Islands',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MQ', 'name' => 'Martinique',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MR', 'name' => 'Mauritania',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MU', 'name' => 'Mauritius',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'YT', 'name' => 'Mayotte',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MX', 'name' => 'Mexico',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'FM', 'name' => 'Micronesia, Federated States of',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MD', 'name' => 'Moldova, Republic of',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MC', 'name' => 'Monaco',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MN', 'name' => 'Mongolia',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'ME', 'name' => 'Montenegro',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MS', 'name' => 'Montserrat',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MA', 'name' => 'Morocco',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MZ', 'name' => 'Mozambique',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MM', 'name' => 'Myanmar',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NA', 'name' => 'Namibia',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NR', 'name' => 'Nauru',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NP', 'name' => 'Nepal',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NC', 'name' => 'New Caledonia',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NI', 'name' => 'Nicaragua',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NE', 'name' => 'Niger',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NG', 'name' => 'Nigeria',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NU', 'name' => 'Niue',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'NF', 'name' => 'Norfolk Island',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MP', 'name' => 'Northern Mariana Islands',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'OM', 'name' => 'Oman',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PK', 'name' => 'Pakistan',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PW', 'name' => 'Palau',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PS', 'name' => 'Palestinian Territory, Occupied',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PA', 'name' => 'Panama',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PG', 'name' => 'Papua New Guinea',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PY', 'name' => 'Paraguay',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PE', 'name' => 'Peru',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PH', 'name' => 'Philippines',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PN', 'name' => 'Pitcairn',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PL', 'name' => 'Poland',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PR', 'name' => 'Puerto Rico',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'QA', 'name' => 'Qatar',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'RE', 'name' => 'Reunion',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'RO', 'name' => 'Romania',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'RW', 'name' => 'Rwanda',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'BL', 'name' => 'Saint Barthélemy',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SH', 'name' => 'Saint Helena',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'KN', 'name' => 'Saint Kitts and Nevis',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LC', 'name' => 'Saint Lucia',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'MF', 'name' => 'Saint Martin (French part)',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'PM', 'name' => 'Saint Pierre and Miquelon',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'VC', 'name' => 'Saint Vincent and the Grenadines',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'WS', 'name' => 'Samoa',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SM', 'name' => 'San Marino',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'ST', 'name' => 'Sao Tome and Principe',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SA', 'name' => 'Saudi Arabia',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SN', 'name' => 'Senegal',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'RS', 'name' => 'Serbia',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SC', 'name' => 'Seychelles',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SL', 'name' => 'Sierra Leone',  'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SG', 'name' => 'Singapore', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SX', 'name' => 'Sint Maarten (Dutch part)', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SK', 'name' => 'Slovakia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SI', 'name' => 'Slovenia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SB', 'name' => 'Solomon Islands', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SO', 'name' => 'Somalia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'ZA', 'name' => 'South Africa', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'GS', 'name' => 'South Georgia and the South Sandwich Islands', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'LK', 'name' => 'Sri Lanka', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SD', 'name' => 'Sudan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SR', 'name' => 'Suriname', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SJ', 'name' => 'Svalbard and Jan Mayen', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SZ', 'name' => 'Swaziland', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'SY', 'name' => 'Syrian Arab Republic', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TW', 'name' => 'Taiwan, Province of China', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TJ', 'name' => 'Tajikistan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TZ', 'name' => 'Tanzania, United Republic of', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TH', 'name' => 'Thailand', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TL', 'name' => 'Timor-Leste', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TG', 'name' => 'Togo', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TK', 'name' => 'Tokelau', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TO', 'name' => 'Tonga', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TT', 'name' => 'Trinidad and Tobago', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TN', 'name' => 'Tunisia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TR', 'name' => 'Turkey', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TM', 'name' => 'Turkmenistan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TC', 'name' => 'Turks and Caicos Islands', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'TV', 'name' => 'Tuvalu', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'UG', 'name' => 'Uganda', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'UA', 'name' => 'Ukraine', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'AE', 'name' => 'United Arab Emirates', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'UM', 'name' => 'United States Minor Outlying Islands', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'UY', 'name' => 'Uruguay', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'UZ', 'name' => 'Uzbekistan', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'VU', 'name' => 'Vanuatu', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'VE', 'name' => 'Venezuela, Bolivarian Republic of', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'VN', 'name' => 'Viet Nam', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'VG', 'name' => 'Virgin Islands, British', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'VI', 'name' => 'Virgin Islands, U.S.', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'WF', 'name' => 'Wallis and Futuna', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'EH', 'name' => 'Western Sahara', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'YE', 'name' => 'Yemen', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'ZM', 'name' => 'Zambia', 'allow_shipping' => false, 'allow_billing' => false],
        [ 'code' => 'ZW', 'name' => 'Zimbabwe', 'allow_shipping' => false, 'allow_billing' => false]
    ]

];
