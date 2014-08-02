<?php

namespace Tga\OpenGraphBundle\Routing;

use Symfony\Component\Routing\Router;

interface RouterAwareInterface
{
    /**
     * @param Router $router
     * @return $this
     */
    public function setRouter(Router $router);

    /**
     * @return Router
     */
    public function getRouter();
}