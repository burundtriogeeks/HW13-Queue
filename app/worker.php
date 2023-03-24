<?php

    require __DIR__ . '/vendor/autoload.php';

    use Beanstalk\Client;

    $beanstalk = new Client([
        'host' => 'host.docker.internal'
    ]);

    $beanstalk->connect();
    $beanstalk->watch('myTube');

    while (true) {
        $job = $beanstalk->reserve();

        $beanstalk->delete($job['id']);
        echo "Job done id ".$job['id']."\n";

        sleep(1);
    }