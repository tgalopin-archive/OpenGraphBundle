<?php

namespace Tga\OpenGraphBundle\Registry;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Tga\OpenGraphBundle\Map\AbstractOpenGraphMap;
use Tga\OpenGraphBundle\Map\OpenGraphMapInterface;
use Tga\OpenGraphBundle\Registry\Exception\FrozenRegistryException;
use Tga\OpenGraphBundle\Routing\RouterAware;
use Tga\OpenGraphBundle\Routing\RouterAwareInterface;

class Registry
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var OpenGraphMapInterface[]
     */
    protected $maps;

    /**
     * @var bool
     */
    protected $frozen = false;


    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param OpenGraphMapInterface $map
     * @return $this
     * @throws Exception\FrozenRegistryException
     */
    public function register(OpenGraphMapInterface $map)
    {
        if ($this->frozen) {
            throw new FrozenRegistryException('register', $map);
        }

        $this->maps[] = $map;

        return $this;
    }

    /**
     * @param OpenGraphMapInterface $map
     * @return bool
     * @throws Exception\FrozenRegistryException
     */
    public function unregister(OpenGraphMapInterface $map)
    {
        if ($this->frozen) {
            throw new FrozenRegistryException('unregister', $map);
        }

        if ($key = array_search($map, $this->maps)) {
            unset($this->maps[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return $this
     */
    public function freeze()
    {
        $this->injectRouter();

        $this->frozen = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFrozen()
    {
        return $this->frozen;
    }

    /**
     * @return OpenGraphMapInterface[]
     */
    public function getMaps()
    {
        return $this->maps;
    }

    /**
     * Inject router in maps extending the abstract one
     *
     * @return \Tga\OpenGraphBundle\Map\OpenGraphMapInterface[]
     */
    protected function injectRouter()
    {
        foreach ($this->maps as $key => $map) {
            if ($map instanceof RouterAwareInterface) {
                $this->maps[$key]->setRouter($this->router);
            }
        }

        return $this->maps;
    }
}