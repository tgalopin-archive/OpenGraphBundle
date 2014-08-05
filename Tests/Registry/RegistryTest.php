<?php

namespace Tga\OpenGraphBundle\Tests\Registry;

use Symfony\Component\Routing\Router;
use Tga\OpenGraphBundle\Registry\Registry;
use Tga\OpenGraphBundle\Tests\Mock\Map;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $router = new Router();

        $registry = new Registry($router);

        $this->assertEquals($router, $registry->getRouter());

        return $registry;
    }

    /**
     * @depends testConstruct
     */
    public function testRegisterUnregister(Registry $registry)
    {
        $map = new Map();

        $this->assertEquals(0, count($registry->getMaps()));

        $registry->register($map);

        $this->assertEquals(1, count($registry->getMaps()));

        $registry->unregister($map);

        $this->assertEquals(0, count($registry->getMaps()));
    }

    /**
     * @depends testConstruct
     */
    public function testFreeze(Registry $registry)
    {
        $registry->register(new Map());

        $this->assertCount(1, $registry->getMaps());

        $registry->freeze();

        $this->assertTrue($registry->isFrozen());
        $this->assertCount(1, $registry->getMaps());

        $registryMaps = $registry->getMaps();
        $firstMap = reset($registryMaps);

        $this->assertEquals($registry->getRouter(), $firstMap->getRouter());

        return $registry;
    }

    /**
     * @depends testFreeze
     * @expectedException \Tga\OpenGraphBundle\Registry\Exception\FrozenRegistryException
     */
    public function testFreezeException(Registry $registry)
    {
        $registry->register($this->getMock('Tga\\OpenGraphBundle\\Map\\OpenGraphMapInterface'));
    }
}
