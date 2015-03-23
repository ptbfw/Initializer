<?php

namespace Ptbfw\Initializer\Initers;

/**
 * Description of Memcached
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class Memcached implements InitializerInterface {

	private $memchached;

	public function __construct($options) {
		$this->memchached = new \Memcached();
		foreach ($options['servers'] as $server) {
			if (isset($options['port'])) {
				$port = $options['port'];
			} else {
				$port = 11211;
			}

			if (isset($options['host'])) {
				$host = $options['host'];
			} else {
				$host = 'localhost';
			}
			$result = $this->memchached->addServer($host, $port);
			if ($result === false) {
				throw new \Exception("cant add memchache server");
			}
		}
	}

	public function reset() {
		$result = $this->memchached->flush();
		if ($result === false) {
			throw new \Exception('memchache clear failed');
		}
	}

}
