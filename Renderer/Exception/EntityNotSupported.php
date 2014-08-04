<?php

namespace Tga\OpenGraphBundle\Renderer\Exception;

use Tga\OpenGraphBundle\Registry\Registry;

/**
 * Thrown when the user try to register / unregister a map after the registry was frozen.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class EntityNotSupported extends \RuntimeException
{
    /**
     * @var object
     */
    protected $entity;

    /**
     * @var \Tga\OpenGraphBundle\Registry\Registry
     */
    protected $registry;

    /**
     * @param object $entity
     * @param Registry $registry
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($entity, Registry $registry, $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('No OpenGraph map in the registry supports class "%s".', get_class($entity)));

        $this->entity = $entity;
        $this->registry = $registry;
    }

    /**
     * @return object
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return \Tga\OpenGraphBundle\Registry\Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }
}
