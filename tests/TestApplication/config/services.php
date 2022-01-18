<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services->load('VisualCraft\\EmailTypesBundle\\Tests\\TestApplication\\', '../src/*')
        ->exclude('../Kernel.php')
    ;
};
