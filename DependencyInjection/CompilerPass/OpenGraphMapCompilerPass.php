<?php

namespace Tga\OpenGraphBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class OpenGraphMapCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (! $container->hasDefinition('tga_open_graph.registry')) {
            return;
        }

        $definition = $container->getDefinition('tga_open_graph.registry');

        $taggedServices = $container->findTaggedServiceIds('open_graph.map');

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('register', [new Reference($id)]);
        }
    }
}