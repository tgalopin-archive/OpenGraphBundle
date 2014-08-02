<?php

namespace Tga\OpenGraphBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tga\OpenGraphBundle\DependencyInjection\CompilerPass\OpenGraphMapCompilerPass;

class TgaOpenGraphBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OpenGraphMapCompilerPass());
    }
}
