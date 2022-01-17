<?php

declare(strict_types=1);

$configuration = [
    'secret' => 'F00',
    'test' => true,
    'mailer' => ['dsn' => 'null://null'],
];

$container->loadFromExtension('framework', $configuration);
