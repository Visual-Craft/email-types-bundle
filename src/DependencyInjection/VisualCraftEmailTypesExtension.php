<?php

declare(strict_types=1);

namespace VisualCraft\EmailTypesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use VisualCraft\EmailTypesBundle\EmailTypeInterface;
use VisualCraft\EmailTypesBundle\Mailer;

class VisualCraftEmailTypesExtension extends Extension
{
    public const EMAIL_TYPE_TAG = 'visual_craft.email_types.type';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $mailer = $container->autowire(Mailer::class);
        $container
            ->registerForAutoconfiguration(EmailTypeInterface::class)
            ->addTag(self::EMAIL_TYPE_TAG)
        ;

        if ($config['default_email_from']) {
            $mailer
                ->addMethodCall('setDefaultFrom', [$config['default_email_from']])
            ;
        }
    }
}
