<?php

namespace Ptbfw\Initializer\Initers;

use \PDO,
    \Symfony\Component\Finder\Finder

;

/**
 * class for MySQL initializtion
 *
 * @author Angel Koilov <angel.koilov@gmail.com>
 */
class Mysql implements Init
{

    private $directories;
    private $user;
    private $pass;
    private $host;
    private $database;
    private $port;

    /**
     * 
     * @param array $options
     */
    function __construct($options)
    {

        $this->directories = $options['directories'];

        $this->user = $options['user'];
        $this->pass = $options['password'];
        $this->host = $options['host'];
        $this->database = $options['database'];

        if (isset($options['port'])) {
            throw new \Exception('port config not implemented');
        }
    }

    public function reset()
    {
        // add full path only for relative dirs
        
        foreach ($this->getDirectories() as $directory) {
            if (!preg_match('~^/~', $directory)) {
                $relativeDir = '../../../../../../../features/bootstrap/database/';
                $sqlDirectory = __DIR__ . '/' . $relativeDir . $directory;
            } else {
                $sqlDirectory = $directory;
            }

            if (!is_dir($sqlDirectory)) {
                throw new \Exception("$sqlDirectory doesn't exist");
            }

            $finder = new Finder();
            foreach ($finder->files()->name('*.sql')->sortByName()->in($sqlDirectory) as $file) {
                /* @var $file \Symfony\Component\Finder\SplFileInfo */
                $c = "mysql -h{$this->host} -u{$this->user} -p{$this->pass} {$this->database} < {$file->getRealPath()}" . PHP_EOL;
                $output = null;
                exec($c, $output);
                if (!empty($output)) {
                    throw new \Exception(print_r($output, true));
                }
            }
        }

    }

    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

}
