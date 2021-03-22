<?php

declare(strict_types=1);

namespace VisualCraft\EmailTypesBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use VisualCraft\EmailTypesBundle\DependencyInjection\VisualCraftEmailTypesExtension;
use VisualCraft\EmailTypesBundle\Mailer;

class RegisterEmailTypesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $types = [];

        foreach ($container->findTaggedServiceIds(VisualCraftEmailTypesExtension::EMAIL_TYPE_TAG) as $id => $attributes) {
            $types[$id] = new Reference($id);
        }

        $container->getDefinition(Mailer::class)
            ->setArgument(2, ServiceLocatorTagPass::register($container, $types))
        ;
    }
}
