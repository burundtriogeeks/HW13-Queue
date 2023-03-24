<?php

    require __DIR__ . '/vendor/autoload.php';

    require __DIR__ . '/config.php';

    $job = str_repeat('my message', 1024);

    if (_QUEUE_TYPE == _QUEUE_TYPE_BEANSTALK) {

        $beanstalk = new Beanstalk\Client([
            'host' => 'host.docker.internal'
        ]);

        $beanstalk->connect();
        $beanstalk->useTube('myTube');
        while (true) {

            $jobId = $beanstalk->put(
                23,
                0,
                60,
                $job
            );


            echo "Job added with id " . $jobId . "\n";

            sleep(1);

        }

        $beanstalk->disconnect();
    }
    if (_QUEUE_TYPE == _QUEUE_TYPE_REDIS_RDB
        || _QUEUE_TYPE == _QUEUE_TYPE_REDIS_AOF
        || _QUEUE_TYPE == _QUEUE_TYPE_REDIS_RDB_AOF
        || _QUEUE_TYPE == _QUEUE_TYPE_REDIS_NO_PERSISTENCE) {

        $ports = [
            1 => 6379,
            2 => 6380,
            3 => 6381,
            4 => 6382
        ];


        $predis = new Predis\Client(
            [
                'host' => 'host.docker.internal',
                'port' =>$ports[_QUEUE_TYPE]
            ]
        );
        $rsmq = new AndrewBreksa\RSMQ\RSMQClient($predis);


        try {
            $rsmq->createQueue('myTube');
        } catch (Exception $e) {

        }

        while(true) {

            $id = $rsmq->sendMessage('myTube', $job);
            echo "Message Sent. ID: " . $id . "\n";
            sleep(1);
        }
    }


