<?php

namespace Octava\Bundle\JobQueueBundle\DependencyInjection;

use JMS\JobQueueBundle\Entity\Job;
use Octava\Bundle\JobQueueBundle\Config;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Octava\Bundle\JobQueueBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('octava_job_queue');

        $rootNode
            ->children()
                ->scalarNode(Config::NODE_DEFAULT_QUEUE)
                    ->info('Restricted queue name')
                    ->cannotBeEmpty()
                    ->defaultValue(Job::DEFAULT_QUEUE)
                ->end()
                ->scalarNode(Config::NODE_QUEUE_DELIMITER)
                    ->cannotBeEmpty()
                    ->defaultValue('@')
                ->end()
                ->arrayNode(Config::NODE_LOCK_COMMANDS)
                    ->info('Command list which should not run simultaneously. (max-concurrent-queues = 1)')
                    ->defaultValue(['cache:clear', 'cache:warmup'])
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
