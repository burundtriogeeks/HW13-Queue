<?php

    define("_QUEUE_TYPE_BEANSTALK",0);
    define("_QUEUE_TYPE_REDIS_RDB",1);
    define("_QUEUE_TYPE_REDIS_AOF",2);
    define("_QUEUE_TYPE_REDIS_RDB_AOF",3);
    define("_QUEUE_TYPE_REDIS_NO_PERSISTENCE",4);

    define("_QUEUE_TYPE",_QUEUE_TYPE_REDIS_RDB);