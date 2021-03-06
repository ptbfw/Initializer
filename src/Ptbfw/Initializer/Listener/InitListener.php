<?php

namespace Ptbfw\Initializer\Listener;

use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Behat\Behat\EventDispatcher\Event\OutlineTested;
use Behat\Mink\Mink;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Behat\Gherkin\Node\OutlineNode;

/**
 * Description of InitListener
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class InitListener implements EventSubscriberInterface
{
    
    private $initers = [];

    /**
     * Initializes initializer.
     *
     * @param Mink        $mink
     * @param string      $defaultSession
     * @param string|null $javascriptSession
     * @param string[]    $availableJavascriptSessions
     */
    public function __construct(array $initerConfigs = [])
    {
        $drivers = [];
        foreach ($initerConfigs as $service => $ServiceOptions) {
            // add namespace only for ptbfw components
            // @TODO find a better way
            if (!preg_match('/\\\\/', $ServiceOptions['type'])) {
                $driverName = 'Ptbfw\\Initializer\\Initers\\' . ucfirst($ServiceOptions['type']);
            }
            if (array_key_exists($service, $drivers)) {
                throw new \Exception("driver {$service} already registered");
            }
            $drivers[$service] = new $driverName($ServiceOptions);
        }
        $this->initers = $drivers;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ScenarioTested::BEFORE => array('init', 100),
            OutlineTested::BEFORE => array('initOutline', 100),
            
            // Used for scenarioOutline
            \Behat\Behat\EventDispatcher\Event\StepTested::BEFORE  => array('beforeStep', 100),
        );
    }

    public function init()
    {
        foreach ($this->initers as $initer) {
            $initer->reset();
        }
    }
    
    public function initOutline()
    {
        // when there is BeforeTableRowEvent
        // this should be used!
    }

    // Used for OutlineScenarious
    // Check if current step is the 1st one from scenario
    // If it is, then do init()
    public function beforeStep(\Behat\Behat\EventDispatcher\Event\BeforeStepTested $event)
    {
        $currentStep = $event->getStep();
        
        $feature = $event->getFeature();
        $scenarios = $feature->getScenarios();
        foreach ($scenarios as $scenario) {
            if ($scenario instanceof OutlineNode) {
                $steps = $scenario->getSteps();
                if (current($steps)->getLine() === $currentStep->getLine()) {
                    $this->init();
                }
            }
        }
    }
}
