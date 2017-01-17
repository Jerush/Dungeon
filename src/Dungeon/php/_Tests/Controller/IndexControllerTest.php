<?php
namespace Test\Controller;

use Dungeon;
use Silex\WebTestCase;

class IndexControllerTest extends WebTestCase
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

    public function testIndexAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue(
            $client->getResponse()->isOk(),
            'The response status is 200'
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'The "Content-Type" header is "application/json"'
        );
    }

    public function testCharacterAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('POST', '/api/characters');

        $this->assertTrue(
            $client->getResponse()->isOk(),
            'The response status is 200'
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'The "Content-Type" header is "application/json"'
        );
    }
}