<?php
namespace Dungeon;

use Silex\Application as Silex;
use Silex\Provider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

class Dungeon extends Silex
{
    use Silex\TwigTrait;
    use Silex\UrlGeneratorTrait;

    /**
     * Dungeon constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct(
            array_merge(
                [
                    'debug' => true,
                    'root' => __DIR__.'/../../..',
                ],
                $values
            )
        );

        // Convert PHP errors to exceptions
        ErrorHandler::register();
        ExceptionHandler::register();


        ///////////////////////////////////////////////////////////////////////
        // PROVIDERS
        ///////////////////////////////////////////////////////////////////////

        // Core
        // - - - - - - - - - - - - - - - - - - - -

        // Assets
        $this->register(new Provider\AssetServiceProvider(), [
            'assets.named_packages' => [
                'app' => [
                    'version' => '1',
                    'version_format' => '%s?v=%s',
                ],
                'lib' => [
                    'version' => '100',
                    'version_format' => '%s?v=%s',
                ],
            ]
        ]);

        // Twig
        $this->register(new Provider\TwigServiceProvider(), [
            'twig.path' => __DIR__ . '/View',
        ]);

        $this->extend('twig', function ($twig) {
            $twig->addExtension(new \Extension\Twig\Extension($this));

            $twig->setLexer(
                new \Twig_Lexer($twig, [
                    'tag_variable' => ['[[', ']]'],
                ])
            );

            return $twig;
        });

        $this['twig.loader.filesystem']->addPath(
            __DIR__ . '/View/components',
            'components'
        );

        $this['twig.loader.filesystem']->addPath(
            __DIR__ . '/View/routes',
            'routes'
        );

        // Application
        // - - - - - - - - - - - - - - - - - - - -

        // MongoDB
        $this->register(new \Dungeon\Provider\MongoServiceProvider(), [
            'mongo.connections' => [
                'default' => [
                    'server' => 'mongodb://192.168.0.20:27017',
                    'options' => [],
                ],
            ],
        ]);


        ///////////////////////////////////////////////////////////////////////
        // ROUTES
        ///////////////////////////////////////////////////////////////////////

        // Middlewares
        // - - - - - - - - - - - - - - - - - - - -

        /**
         * Imposto il numero di cache e di versione.
         */
        $this->before(function (Request $request, Silex $app) {
            // Imposto il numero di versione
            $request->attributes->set('version', '1.0.0+1000');

            // Recupero l'ultimo file modificato
            foreach (['/src/Dungeon/', '/www/assets/html/'] as $path) {
                $directory = new \RecursiveDirectoryIterator($app['root'] . $path);
                $iterator = new \RecursiveIteratorIterator($directory);
                $regex = new \RegexIterator($iterator, '/^.+\.(html|js|php|scss|twig)$/i', \RecursiveRegexIterator::GET_MATCH);

                foreach ($regex as $filename) {
                    $mtime = filemtime($filename[0]);

                    if ($request->attributes->get('cache') < $mtime) {
                        $request->attributes->set('cache', $mtime);
                    }
                }
            }
        });


        ///////////////////////////////////////////////////////////////////////
        // CONTROLLERS
        ///////////////////////////////////////////////////////////////////////

        $providers = [
            '/' => [
                new Controller\IndexController($this),
            ],
        ];

        foreach ($providers as $prefix => $controllers) {
            foreach ($controllers as $controller) {
                $this->mount($prefix, $controller);
            }
        }
    }
}