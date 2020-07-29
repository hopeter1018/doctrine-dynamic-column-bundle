<?php

namespace HoPeter1018\DoctrineDynamicColumnBundle\DependencyInjection;

use HoPeter1018\DoctrineDynamicColumnBundle\Annotation\Column;
use HoPeter1018\DoctrineDynamicColumnBundle\Annotation\Entity;
use HoPeter1018\DoctrineDynamicColumnBundle\CacheWarm\MappingCacheWarmUp;
use HoPeter1018\DoctrineDynamicColumnBundle\EventListener\DynamicColumnSubscriber;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class HoPeter1018DoctrineDynamicColumnExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $serviceDefintion = $container->getDefinition(MappingCacheWarmUp::class);
        $serviceDefintion->setArgument(0, $config);

        $serviceDefintion = $container->getDefinition(DynamicColumnSubscriber::class);
        $serviceDefintion->setArgument(0, $config);

        $this->addAnnotatedClassesToCompile([
            Entity::class,
            Column::class,
        ]);
    }
}
