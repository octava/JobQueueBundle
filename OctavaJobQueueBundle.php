<?php

namespace Octava\Bundle\JobQueueBundle;

use Octava\Bundle\JobQueueBundle\DependencyInjection\Compiler\DefaultQueueCompiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class OctavaJobQueueBundle
 * @package Octava\Bundle\JobQueueBundle
 */
class OctavaJobQueueBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DefaultQueueCompiler());
    }
}
