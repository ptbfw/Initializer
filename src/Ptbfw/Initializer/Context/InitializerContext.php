<?php

namespace Ptbfw\Initializer\Context;

/**
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class InitializerContext extends \Behat\Behat\Context\BehatContext {

	private $params;
	private static $databaseDrivers = array();

	function __construct($params) {
		$this->params = $params;
	}

	/**
	 * 
	 * Restore mink sessions from config
	 * Restart database
	 * 
	 * @BeforeScenario 
	 * @param \Behat\Behat\Event\ScenarioEvent $event
	 */
	public function before($event) {
		$drivers = array();

		$options = $this->params;

		if (!empty($options)) {
			foreach ($options as $service => $ServiceOptions) {
				// add namespace only for ptbf components
				if (!preg_match('/\\\\/', $ServiceOptions['type'])) {
					$driverName = 'Ptbfw\\Initializer\\Initers\\' . ucfirst($ServiceOptions['type']);
				}
				if (array_key_exists($service, $drivers)) {
					throw new Exception("driver {$service} already registered");
				}
				$drivers[$service] = new $driverName($service, $ServiceOptions);
			}
			self::$databaseDrivers = $drivers;
		}


		$this->databaseReset();
	}

	public function getDatabaseDrivers() {
		return self::$databaseDrivers;
	}

	public function databaseReset() {
		foreach ($this->getDatabaseDrivers() as $d) {
			$d->reset();
		}
	}

}

