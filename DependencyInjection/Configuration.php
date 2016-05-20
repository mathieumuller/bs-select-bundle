<?php

namespace Axiolab\BootstrapSelectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('axiolab_bootstrap_select');

        $rootNode
            ->children()
                ->scalarNode('form_resource')
                    ->defaultValue('AxiolabBootstrapSelectBundle:form:bootstrapSelect.html.twig')
                ->end()
                ->booleanNode('show_tick')
                    ->defaultTrue()
                ->end()
                ->scalarNode('preferred_language')
                    ->defaultValue('en_US')
                ->end()
                ->integerNode('search_start')
                    ->defaultValue(3)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
