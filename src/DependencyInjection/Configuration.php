<?php

declare(strict_types=1);

namespace VisualCraft\EmailTypesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('visual_craft_email_types');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('default_email_from')->defaultNull()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
