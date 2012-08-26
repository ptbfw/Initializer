<?php

namespace Ptbfw\Initializer\Context;

use Behat\Behat\Context\Initializer\InitializerInterface;
use Behat\Behat\Context\ContextInterface;

/**
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class InitializerInitializer implements InitializerInterface {

	private $parameters;

	function __construct(array $params) {
		$this->parameters = $params;
		
	}

	
	/**
	 * Initializes initializer.
	 *
	 * @param array $parameters
	 */
//put your code herepublic function initialize(ContextInterface $context){
	public function supports(ContextInterface $context) {
		if ($context instanceof \Ptbfw\Initializer\InitializerAwareInterface) {
			return true;
		} else {
			return false;
		}
	}

	public function initialize(ContextInterface $context) {
		/* @var $context \Behat\Behat\Context\BehatContext */
		$context->useContext('ptbfw\\Initializer\\Context\\Initializer', new \Ptbfw\Initializer\Context\InitializerContext($this->parameters));
	}
	
	

}
