<?php

namespace Octava\Bundle\JobQueueBundle;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use JMS\JobQueueBundle\Entity\Job;
use JMS\JobQueueBundle\Entity\Repository\JobRepository;
use Octava\Bundle\JobQueueBundle\Model\JobCollection;

/**
 * Class Manager
 * @package Octava\Bundle\JobQueueBundle
 */
class Manager
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \ReflectionClass
     */
    protected $reflection;

    /**
     * Manager constructor.
     * @param EntityManager $entityManager
     * @param Config        $config
     */
    public function __construct(EntityManager $entityManager, Config $config)
    {
        $this->entityManager = $entityManager;
        $this->config = $config;
    }

    /**
     * @param Job $job
     * @return JobCollection
     */
    public function broadcast(Job $job)
    {
        $result = new JobCollection();
        foreach ($this->config->getQueues() as $queue) {
            $newJob = $this->cloneJob($job, $queue);
            $result->add($newJob);

            $this->entityManager->persist($newJob);
        }

        return $result;
    }

    /**
     * @param Job $job
     * @return Job
     */
    public function distinct(Job $job)
    {
        $result = $this->cloneJob($job, $this->config->getDefaultQueue());
        $this->entityManager->persist($result);

        return $result;
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

    /**
     * @return EntityRepository|JobRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository(Job::class);
    }

    /**
     * @param Job    $job
     * @param string $queue
     * @return Job
     */
    protected function cloneJob(Job $job, $queue)
    {
        $command = $job->getCommand();
        $newQueueName = $this->config->buildQueueName($queue, $command);
        $result = clone $job;

        foreach ($this->getReflection()->getProperties() as $property) {
            $property->setAccessible(true);
            if ('queue' == $property->getName()) {
                $property->setValue($result, $newQueueName);
            } else {
                $value = $property->getValue($job);
                $property->setValue($result, $value);
            }
        }

        return $result;
    }

    protected function getReflection()
    {
        if (is_null($this->reflection)) {
            $this->reflection = new \ReflectionClass(Job::class);
        }

        return $this->reflection;
    }
}
