<?php

namespace Ptbfw\Initializer;

use Symfony\Component\DependencyInjection\ContainerBuilder,
	Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
	Symfony\Component\Config\FileLocator

;

/**
 * Ptbfw extension for project initialization
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class Extension extends \Behat\Behat\Extension\Extension {

	public function load(array $config, ContainerBuilder $container) {
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/services'));
		$loader->load('core.xml');
		$container->setParameter('ptbfw.initializer.parameters', $config);
	}

}
