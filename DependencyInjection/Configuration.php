<?php
namespace AxioLab\BootstrapSelectBundle\DependencyInjection;

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
                    ->defaultValue('AxioLabBootstrapSelectBundle:form:bootstrapSelect.html.twig')
                ->end()
                ->booleanNode('show_tick')
                    ->defaultFalse()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
