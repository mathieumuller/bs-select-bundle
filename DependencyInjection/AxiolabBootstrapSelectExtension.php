<?php
namespace Axiolab\BootstrapSelectBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class AxiolabBootstrapSelectExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config  = $this->processConfiguration(new Configuration(), $configs);

        $bundles = $container->getParameter('kernel.bundles');
        //prepend assetic
        if (true === isset($bundles['AsseticBundle'])) {
            $this->configureAssetic($container);
        }
        //prepend twig
        if (true === isset($bundles['TwigBundle'])) {
            $this->configureTwig($container, $config);
        }
    }


    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');

        $bundleParameters = [];
        foreach ($config as $node => $value) {
            $bundleParameters[$node] = $value;
        }
        $container->setParameter('axiolab_bootstrap_select', $bundleParameters);
    }

    public function getAlias()
    {
        return 'axiolab_bootstrap_select';
    }

    protected function configureAssetic(ContainerBuilder $container)
    {
        $jsPath = '%kernel.root_dir%/../vendor/axiolab/bs-select-bundle/Resources/public/js';
        $jsConfig = [
            'axiolab_bootstrap_select' => [
                'inputs'  => [
                    $jsPath.'/bootstrap-select.js',
                    $jsPath.'/i18n/defaults-fr_FR.min.js',
                    $jsPath.'/ajax.js',
                ],
                'output' => 'js/axiolabbootstrapselect.js'
            ]
        ];

        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'assetic':
                    $container->prependExtensionConfig(
                        $name,
                        ['assets' => $jsConfig]
                    );
                    break;
                default:
                    break;
            }
        }
    }

    protected function configureTwig(ContainerBuilder $container, $config)
    {
        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'twig':
                    $container->prependExtensionConfig(
                        $name,
                        [
                            'form_themes' => [$config['form_resource']]
                        ]
                    );
                    break;
                default:
                    break;
            }
        }
    }
}
