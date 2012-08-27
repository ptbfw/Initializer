<?php

namespace Ptbfw\Initializer\Initers;

/**
 * 
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
interface Init {

	/**
	 * 
	 * @param string $name
	 * @param array $options
	 */
	public function __construct($name, $options);

	public function reset();
}
