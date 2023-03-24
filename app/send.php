<?php

    require __DIR__ . '/vendor/autoload.php';

    use Beanstalk\Client;

    $beanstalk = new Client([
        'host' => 'host.docker.internal'
    ]);

    $beanstalk->connect();
    $beanstalk->useTube('myTube');
    while(true) {
        $jobId = $beanstalk->put(
            23,
            0,
            60,
            'my message'
        );


        echo "Job added with id " . $jobId . "\n";

        sleep(1);

    }

    $beanstalk->disconnect();


