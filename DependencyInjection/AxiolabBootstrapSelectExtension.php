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
        $config = $this->processConfiguration(new Configuration(), $configs);

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

        $bundles = $container->getParameter('kernel.bundles');
        //prepend assetic
        if (true === isset($bundles['AsseticBundle'])) {
            $this->configureAssetic($container);
        }
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $this->configureTwig($container);
    }

    public function getAlias()
    {
        return 'axiolab_bootstrap_select';
    }

    protected function configureAssetic(ContainerBuilder $container)
    {
        $paramLang = $container->getParameter('axiolab_bootstrap_select')['preferred_language'];
        $language = empty($paramLang) ? 'en_US' : $paramLang;
        $jsPath = '%kernel.root_dir%/../vendor/axiolab/bs-select-bundle/Resources/public/js';
        $jsConfig = [
            'axiolab_bootstrap_select' => [
                'inputs' => [
                    $jsPath.'/bootstrap-select.js',
                    $jsPath.'/i18n/defaults-'.$language.'.min.js',
                    $jsPath.'/ajax.js',
                ],
                'output' => 'js/axiolabbootstrapselect.js',
            ],
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

    protected function configureTwig(ContainerBuilder $container)
    {
        $resources = [];
        if ($container->hasParameter('twig.form.resources')) {
            $resources = $container->getParameter('twig.form.resources');
        }

        $resources[] = $container->getParameter('axiolab_bootstrap_select')['form_resource'];

        $container->setParameter('twig.form.resources', $resources);
    }
}
