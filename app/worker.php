<?php

    require __DIR__ . '/vendor/autoload.php';

    require __DIR__ . '/config.php';

    if (_QUEUE_TYPE == _QUEUE_TYPE_BEANSTALK) {

        $beanstalk = new Beanstalk\Client([
            'host' => 'host.docker.internal'
        ]);

        $beanstalk->connect();
        $beanstalk->watch('myTube');

        while (true) {
            $job = $beanstalk->reserve();

            $beanstalk->delete($job['id']);
            echo "Job done id " . $job['id'] . "\n";

            sleep(1);
        }
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

        while (true) {

            $message = $rsmq->popMessage('myTube');
            if (isset($message)) {
                echo "Message pop ID: ".$message->getId()."\n";
            } else {
                echo "No messages in queue\n";
            }
            sleep(1);
        }


    }
