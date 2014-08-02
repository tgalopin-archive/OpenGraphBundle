<?php

namespace Tga\OpenGraphBundle\Registry\Exception;

use Tga\OpenGraphBundle\Map\OpenGraphMapInterface;

/**
 * Thrown when the user try to register / unregister a map after the registry was frozen.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class FrozenRegistryException extends \RuntimeException
{
    /**
     * @var OpenGraphMapInterface
     */
    protected $map;

    /**
     * @param string $action
     * @param OpenGraphMapInterface $map
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($action, OpenGraphMapInterface $map, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf(
            'The OpenGraph maps registry can not be modified after it has been frozen (trying to %s map "%s")',
            $action, get_class($map)
        ));

        $this->map = $map;
    }

    /**
     * @return \Tga\OpenGraphBundle\Map\OpenGraphMapInterface
     */
    public function getMap()
    {
        return $this->map;
    }
}
