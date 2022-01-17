
<?php

use VisualCraft\EmailTypesBundle\Tests\TestApplication\src\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;

// needed to avoid encoding issues when running tests on different platforms
setlocale(\LC_ALL, 'en_US.UTF-8');

// needed to avoid failed tests when other timezones than UTC are configured for PHP
date_default_timezone_set('UTC');

// we want final classes in code but we need non-final classes in tests
// after trying many solutions (see https://tomasvotruba.com/blog/2019/03/28/how-to-mock-final-classes-in-phpunit/)
// none ws reliable enough, so this custom solution removes the 'final' keyword
// from the source code of all project files (and restore it when tests finish)
// This has to be done BEFORE loading any PHP classes. Otherwise the changes in the
// source code contents are ignored


$file = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies using Composer to run the test suite.');
}
$autoload = require $file;
