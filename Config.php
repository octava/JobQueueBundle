<?php

namespace Octava\Bundle\JobQueueBundle;

use JMS\JobQueueBundle\Entity\Job;

/**
 * Class Config
 * @package Octava\Bundle\JobQueueBundle
 */
class Config
{
    const NODE_DEFAULT_QUEUE = 'default_queue';
    const NODE_LOCK_COMMANDS = 'lock_commands';
    const NODE_QUEUE_DELIMITER = 'queue_delimiter';

    /**
     * @var array
     */
    protected $config;

    /**
     * Config constructor.
     * @param array $config
     * @param array $options
     */
    public function __construct(array $config, array $options = [])
    {
        $this->config = $config;
        $this->options = $options;

        $this->validate();
    }

    /**
     * @return string[]
     */
    public function getQueues()
    {
        $result = [$this->config[self::NODE_DEFAULT_QUEUE]];
        if (!empty($this->options)) {
            $result = array_keys($this->options);
        }

        return $result;
    }

    /**
     * Список очередей для конктреного сервера
     * @return array
     */
    public function getRestrictedQueues()
    {
        $result = [];
        $result[] = $this->getDefaultQueue();
        foreach ($this->getLockCommands() as $command) {
            $result[] = $this->buildLockQueue($this->getDefaultQueue(), $command);
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getDefaultQueue()
    {
        return $this->config[self::NODE_DEFAULT_QUEUE];
    }

    /**
     * @return array
     */
    public function getLockCommands()
    {
        return array_filter($this->config[self::NODE_LOCK_COMMANDS]);
    }

    /**
     * @return array
     */
    public function getLockQueues()
    {
        $commands = $this->getLockCommands();
        $result = [];
        foreach ($this->getQueues() as $queue) {
            foreach ($commands as $command) {
                $result[] = $this->buildLockQueue($queue, $command);
            }
        }

        return $result;
    }

    /**
     * @param string $queue
     * @param string $command
     * @return string
     */
    public function buildQueueName($queue, $command)
    {
        $result = $queue;

        if (in_array($command, $this->getLockCommands())) {
            $result = $this->buildLockQueue($queue, $command);
        }

        return $result;
    }

    /**
     * @param string $queue
     * @param string $command
     * @return string
     */
    protected function buildLockQueue($queue, $command)
    {
        return $queue.$this->getDelimiter().$command;
    }

    /**
     * @return string
     */
    protected function getDelimiter()
    {
        return $this->config[self::NODE_QUEUE_DELIMITER];
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function validate()
    {
        if (!empty($this->options)
            && Job::DEFAULT_QUEUE !== $this->getDefaultQueue()
            && !array_key_exists($this->getDefaultQueue(), $this->options)
        ) {
            throw new \InvalidArgumentException(
                sprintf('"%s" queue name not found in jms_job_queue.queue_options', $this->getDefaultQueue())
            );
        }
    }
}
