<?php

namespace Ptbfw\Initializer\Listener;

use Behat\Behat\EventDispatcher\Event\ExampleTested;
use Behat\Behat\EventDispatcher\Event\ScenarioLikeTested;
use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Behat\Behat\EventDispatcher\Event\OutlineTested;
use Behat\Mink\Mink;
use Behat\Testwork\EventDispatcher\Event\ExerciseCompleted;
use Behat\Testwork\ServiceContainer\Exception\ProcessingException;
use Behat\Testwork\Suite\Exception\SuiteConfigurationException;
use Behat\Testwork\Suite\Suite;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

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
                throw new Exception("driver {$service} already registered");
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
        );
    }

    public function init()
    {
        foreach ($this->initers as $initer) {
            $initer->reset();
        }
    }
    
    public function initOutline(Event $event)
    {
        throw new \Exception('Outline scenarious not implemented');
    }

}
