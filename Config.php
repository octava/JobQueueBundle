<?php

namespace Octava\Bundle\JobQueueBundle;

class Config
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
