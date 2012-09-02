<?php

namespace Ptbfw\Initializer\Initers;

/**
 * 
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
interface Init {

	/**
	 * 
	 * @param array $options
	 */
	public function __construct($options);

	public function reset();
}
