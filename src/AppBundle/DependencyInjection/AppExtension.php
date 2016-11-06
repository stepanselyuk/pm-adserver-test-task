<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AppExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $env = $container->getParameter('kernel.environment');

        if ($env === 'prod') {
            $loader->load('services_prod.yml');
        }
        if ($env === 'test') {
            $loader->load('services_test.yml');
        }
        if ($env === 'dev') {
            $loader->load('services_dev.yml');
        }
        if ($env === 'test' || $env === 'dev') {
            $loader->load('services_fake.yml');
        }
    }
}
