<?php

namespace Ptbfw\Initializer\Initers;

/**
 * Description of Executer
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class Executer implements Init {

	private $commands;

	public function __construct($options) {

		if (!function_exists('shell_exec')) {
			throw new \Exception('shell_exec not found in php function');
		}

		if (is_string($options['commands'])) {
			$this->commands = array($options);
		} elseif (is_array($options)) {
			foreach ($options['commands'] as $option) {
				$this->commands[] = (string) $option;
			}
		} else {
			throw new \Exception('unsupported type for ' . __CLASS__);
		}
	}

	public function reset() {
		foreach ($this->commands as $command) {
			$result = shell_exec($command);
			if ($result === NULL) {
				throw new \Exception("error executin [[[{$command}]]] or nothing outputed");
			}
		}
	}

}
