# job-queue-bundle
One more wrapper for jms/job-queue-bundle. 
Global aim is working with multi-server architecture of you project. 
For example, cache:clear command needs to run for all your server.
In this case **job queue** means **server**.

```php
$manager = $container->get('octava_bundle_job_queue.manager');
$job = new Job('cache:clear');

$jobs = $manager->broadcast($job); //create job for all queues
or
$jobs = $manager->distinct($job); //create job for a default queue 

$manager->flush($jobs);
```

## Installation

You can easily install OctavaJobQueueBundle with composer. Just add the following to your `composer.json`file:
```json
// composer.json
{
    // ...
    "require": {
        // ...
        "jms/job-queue-bundle": "dev-symfony4",
        "sonata-project/admin-bundle": "4.x-dev",
        "octava/job-queue-bundle": "4.0.x-dev"
    }
}
```

Put your server list as list of queue and define a default_queue.
```yaml
#parameters.yml
parameters:
    #...
    default_queue: web-server1

#config.yml
jms_job_queue:
    queue_options:
        web-server1: ~
        web-server2: ~
        web-server3: ~

octava_job_queue:
    default_queue: '%default_queue%' #web-server1
```

Then, you can install the new dependencies by running composer’s update command from the directory where your composer.json file is located:

```bash
composer update jms/job-queue-bundle octava/job-queue-bundle
```

Now, Composer will automatically download all required files, and install them for you. Next you need to update your AppKernel.php file, and register the new bundle:

```php
<?php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new JMS\JobQueueBundle\JMSJobQueueBundle(),
    new Octava\Bundle\JobQueueBundle\OctavaJobQueueBundle(),
    // ...
);
```

Have your app/console use JMSJobQueueBundle’s Application:
```php
// use Symfony\Bundle\FrameworkBundle\Console\Application;
use JMS\JobQueueBundle\Console\Application;
```

Finally, use the console command ```ocatava-job-queue:run``` for job execution.
