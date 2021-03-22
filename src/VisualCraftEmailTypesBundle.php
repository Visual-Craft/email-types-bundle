<?php

declare(strict_types=1);

namespace VisualCraft\EmailTypesBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use VisualCraft\EmailTypesBundle\DependencyInjection\CompilerPass\RegisterEmailTypesCompilerPass;

class VisualCraftEmailTypesBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterEmailTypesCompilerPass());
    }
}
