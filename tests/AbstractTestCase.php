<?php
namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AbstractTestCase
 * @package Tests
 */
abstract class AbstractTestCase extends WebTestCase
{
    /**
     * @var bool
     */
    protected static $dataChanged = true;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @return boolean
     */
    public static function isDataChanged()
    {
        return self::$dataChanged;
    }

    /**
     * @param boolean $dataChanged
     */
    public static function setDataChanged($dataChanged)
    {
        self::$dataChanged = $dataChanged;
    }

    protected function setUp()
    {
        $this->client = static::createClient();
        if (static::isDataChanged()) {
            $this->flushDatabase();
            static::setDataChanged(false);
        }
    }

    protected function flushDatabase()
    {
        //Re-create database from fixtures
        shell_exec('php bin/console doctrine:database:drop --force --env=test;');
        shell_exec('php bin/console doctrine:database:create --env=test;');
        shell_exec('php bin/console doctrine:schema:update --force --env=test;');
        shell_exec('php bin/console doctrine:fixtures:load --env=test --append;');
    }
}
