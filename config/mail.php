<?php

return [
'default'=>'smtp',
    'mailers' => [
        'smtp' => [
'transport'=>'smtp',
'host'=>'smtp.gmail.com',
'port'=>'587',
'encryption'=>'tls',
'username'=>'hello@joinpigeon.com',
'password'=>'egqbsbvprqdezedr',
            'timeout' => null,
            'auth_mode' => null,
        ],
        'ses' => [
            'transport' => 'ses',
        ],
        'mailgun' => [
            'transport' => 'mailgun',
        ],
        'postmark' => [
            'transport' => 'postmark',
        ],
        'sendmail' => [
            'transport' => 'sendmail',
            'path' => '/usr/sbin/sendmail -bs',
        ],
        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],
        'array' => [
            'transport' => 'array',
        ],
    ],
    'from' => [
'address' => env('MAIL_FROM_ADDRESS', 'hello@joinpigeon.com'),
'name' => env('MAIL_FROM_NAME', 'Example'),
    ],
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
