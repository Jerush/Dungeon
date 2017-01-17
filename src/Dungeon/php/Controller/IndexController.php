<?php
namespace Dungeon\Controller;

use Pimple\Container;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class IndexController implements
    ControllerProviderInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * IndexController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function connect(Application $app)
    {
        $router = $app['controllers_factory'];

        $router->get('/',
            function (
                Application $app
            ) {
                return $app->render('index.twig');
            }
        );

        $router->post('/api/characters',
            function (
                Application $app
            ) {
                $collection = $app['mongo.db']->selectDatabase('Dungeon')
                                              ->selectCollection('Resources');

                $results = [];
                foreach ($collection->find() as $document) {
                    $results[] = [
                        '$id'  => $document['_id'],
                        'name' => $document['name'],
                    ];
                }

                return $app->json([
                    'results' => $results,
                ]);
            }
        );

        return $router;
    }
}