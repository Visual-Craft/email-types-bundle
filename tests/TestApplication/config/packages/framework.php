<?php

$configuration = [
    'secret' => 'F00',
    'test' => true,
    'mailer' => ['dsn' => 'null://null'],
];

$container->loadFromExtension('framework', $configuration);
