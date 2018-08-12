<?php
/**
 * This is the configuration file for the 'yii2-authclient' unit tests.
 * You can override configuration values by creating a `config.local.php` file
 * and manipulate the `$config` variable.
 */

$config = [
    'components' => [
        'typeform' => [
            'class' => \tonyaxo\yii2typeform\TypeForm::class,
            'clientId' => '', // e.g. 'your-typeform-application-id'
            'clientSecret' => '', // e.g. 'your-typeform-application-secret'
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
    ],
];

if (is_file(__DIR__ . '/config.local.php')) {
    include(__DIR__ . '/config.local.php');
}

return $config;