<?php
namespace Dungeon\Provider;

use MongoDB;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MongoServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $app)
    {
        $app['mongo.options'] = [];

        $app['mongo.dbs'] = function () use ($app) {
            $dbs = new Container();

            if ( ! isset($app['mongo.connections'])) {
                $app['mongo.connections'] = [
                    'default' => [
                        'server' => 'mongodb://localhost:27017',
                        'options' => [],
                    ],
                ];
            }

            foreach ($app['mongo.connections'] as $name => $params) {
                if ( ! isset($app['mongo.dbs.default'])) {
                    $app['mongo.dbs.default'] = $name;
                }

                $dbs[$name] = function ($dbs) use ($app, $params) {
                    return new MongoDB\Client($params['server'], $params['options'] ?: [], $app['mongo.options']);
                };
            }

            return $dbs;
        };

        // Shortcuts for the "first" DB
        $app['mongo.db'] = function ($app) {
            $dbs = $app['mongo.dbs'];

            return $dbs[$app['mongo.dbs.default']];
        };
    }
}