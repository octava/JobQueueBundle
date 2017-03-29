<?php

namespace Octava\Bundle\JobQueueBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class JobAdmin
 * @package Octava\Bundle\JobQueueBundle\Admin
 */
class JobAdmin extends AbstractAdmin
{
    /**
     * @var array
     */
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, ['label' => 'admin.id'])
            ->add('state', null, ['label' => 'admin.state'])
            ->add('queue', null, ['label' => 'admin.queue'])
            ->add('priority', null, ['label' => 'admin.priority'])
            ->add('workerName', null, ['label' => 'admin.worker_name'])
            ->add('command', null, ['label' => 'admin.command'])
            ->add('exitCode', null, ['label' => 'admin.exit_code']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, ['label' => 'admin.id'])
            ->add('state', null, ['label' => 'admin.state'])
            ->add('queue', null, ['label' => 'admin.queue'])
            ->add('priority', null, ['label' => 'admin.priority'])
            ->add('createdAt', null, ['label' => 'admin.created_at'])
            ->add('startedAt', null, ['label' => 'admin.started_at'])
            ->add('checkedAt', null, ['label' => 'admin.checked_at'])
            ->add('workerName', null, ['label' => 'admin.worker_name'])
            ->add('executeAfter', null, ['label' => 'admin.execute_after'])
            ->add('closedAt', null, ['label' => 'admin.closed_at'])
            ->add('command', null, ['label' => 'admin.command'])
            ->add('exitCode', null, ['label' => 'admin.exit_code'])
            ->add('maxRuntime', null, ['label' => 'admin.max_runtime'])
            ->add('maxRetries', null, ['label' => 'admin.max_retries'])
            ->add('runtime', null, ['label' => 'admin.runtime'])
            ->add('memoryUsage', null, ['label' => 'admin.memory_usage'])
            ->add('memoryUsageReal', null, ['label' => 'admin.memory_usage_real'])
            ->add(
                '_action',
                null,
                [
                    'actions' => [
                        'show' => [],
                        'delete' => [],
                    ],
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, ['label' => 'admin.id'])
            ->add('state', null, ['label' => 'admin.state'])
            ->add('queue', null, ['label' => 'admin.queue'])
            ->add('priority', null, ['label' => 'admin.priority'])
            ->add('createdAt', null, ['label' => 'admin.created_at'])
            ->add('startedAt', null, ['label' => 'admin.started_at'])
            ->add('checkedAt', null, ['label' => 'admin.checked_at'])
            ->add('workerName', null, ['label' => 'admin.worker_name'])
            ->add('executeAfter', null, ['label' => 'admin.execute_after'])
            ->add('closedAt', null, ['label' => 'admin.closed_at'])
            ->add('command', null, ['label' => 'admin.command'])
            ->add('args', 'array', ['label' => 'admin.args'])
            ->add('output', null, ['label' => 'admin.output'])
            ->add('errorOutput', null, ['label' => 'admin.error_output'])
            ->add('exitCode', null, ['label' => 'admin.exit_code'])
            ->add('maxRuntime', null, ['label' => 'admin.max_runtime'])
            ->add('maxRetries', null, ['label' => 'admin.max_retries'])
            ->add('stackTrace', null, ['label' => 'admin.stack_trace'])
            ->add('runtime', null, ['label' => 'admin.runtime'])
            ->add('memoryUsage', null, ['label' => 'admin.memory_usage'])
            ->add('memoryUsageReal', null, ['label' => 'admin.memory_usage_real']);
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('edit');
    }
}
