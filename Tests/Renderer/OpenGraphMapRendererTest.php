<?php

namespace Tga\OpenGraphBundle\Tests\Renderer;

use Symfony\Component\Routing\Router;
use Tga\OpenGraphBundle\Registry\Registry;
use Tga\OpenGraphBundle\Renderer\OpenGraphMapRenderer;
use Tga\OpenGraphBundle\Tests\Mock\Map;

class OpenGraphMapRendererTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $router = new Router();

        $registry = new Registry($router);
        $registry->register(new Map());

        $renderer = new OpenGraphMapRenderer($registry);

        $this->assertEquals($renderer->getRegistry(), $registry);
        $this->assertEquals($renderer->getRegistry()->getRouter(), $registry->getRouter());

        return $renderer;

    }

    /**
     * @depends testConstruct
     */
    public function testRenderValid(OpenGraphMapRenderer $renderer)
    {
        $entity = new \stdClass();
        $entity->name = 'TestName';

        $this->assertTrue(strpos($renderer->render($entity), '<meta property="og:title" content="TestName" />') !== false);
    }

    /**
     * @expectedException \Tga\OpenGraphBundle\Renderer\Exception\EntityNotSupported
     */
    public function testRenderInvalid()
    {
        $router = new Router();
        $registry = new Registry($router);
        $renderer = new OpenGraphMapRenderer($registry);

        $entity = new \stdClass();
        $entity->name = 'TestName';

        $renderer->render($entity);
    }
}
