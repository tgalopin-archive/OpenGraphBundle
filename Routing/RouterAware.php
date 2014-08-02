<?php

namespace Tga\OpenGraphBundle\Routing;

use Symfony\Component\Routing\Router;

abstract class RouterAware implements RouterAwareInterface
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @param Router $router
     * @return $this
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }
}