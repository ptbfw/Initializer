<?php

namespace Ptbfw\Initializer;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Component\Config\FileLocator
;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Symfony\Component\DependencyInjection\Definition;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;

/**
 * Ptbfw extension for project initialization
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class Extension implements ExtensionInterface
{

    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/services'));
        $loader->load('core.xml');
        $container->setParameter('ptbfw.initializer.parameters', $config);
        
        
        $definition = new Definition('Ptbfw\Initializer\Listener\InitListener', $config);
        $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG, array('priority' => 100));
        $container->setDefinition('ptbfw.initializer.initListener', $definition);
        
    }

    public function configure(\Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $builder)
    {
        $builder
                ->children()
                    ->arrayNode('resetters')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('type')
                                ->end()
                                ->scalarNode('user')
                                ->end()
                                ->scalarNode('password')
                                ->end()
                                ->scalarNode('host')
                                ->end()
                                ->scalarNode('database')
                                ->end()
                                ->scalarNode('init_command')
                                ->end()
                                ->scalarNode('directory')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();
    }

    public function getConfigKey()
    {
        return 'PtbfwInitializer';
    }

    public function initialize(\Behat\Testwork\ServiceContainer\ExtensionManager $extensionManager)
    {
        
    }

    public function process(ContainerBuilder $container)
    {

    }

}
