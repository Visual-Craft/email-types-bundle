<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services->load('VisualCraft\\EmailTypesBundle\\Tests\\TestApplication\\', '../src/*')
        ->exclude('../Kernel.php');
};