<?php
namespace Test\Provider;

use Dungeon;
use MongoDB;
use Silex\WebTestCase;

class MongoServiceProviderTest extends WebTestCase
{
    /**
     * @inheritDoc
     */
    public function createApplication()
    {
        $app = new Dungeon\Dungeon();

        // Disable default HTML exception handler
        unset($app['exception_handler']);

        return $app;
    }

    public function testClient()
    {
        #$twig = $this->app['twig'];
        #$mongo = $this->app['mongo.db'];

        $driver = new MongoDB\Driver\Manager('');

        /* $this->assertTrue(
            $mongo->selectDatabase('System') instanceof MongoDB\Database,
            'The "mongo.connections.default" in an instance of MongoDB\Client'
        ); */
    }
}