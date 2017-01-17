<?php
namespace Extension\Twig;

use Pimple\Container;
use Twig_Extension;
use Twig_SimpleFilter;

class Extension extends Twig_Extension
{
    protected $container;

    /**
     * Extension constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return [];
    }
}