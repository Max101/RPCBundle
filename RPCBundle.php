<?php

namespace MO\RPCBundle;

use MO\RPCBundle\DependencyInjection\Compiler\RPCCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RPCBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RPCCompilerPass(), PassConfig::TYPE_AFTER_REMOVING);
    }
}
