# HW13-Queue

# Selection of queue type

To select type of queue change value of _QUEUE_TYPE constant in _/app/config.php_

_QUEUE_TYPE_BEANSTALK - use Beanstalk with binlog

_QUEUE_TYPE_REDIS_RDB - use Redis with turned on save option and turned off appendonly

_QUEUE_TYPE_REDIS_AOF - use Redis with turned off save option and turned on appendonly

_QUEUE_TYPE_REDIS_RDB_AOF - use Redis with turned on save option and turned on appendonly

_QUEUE_TYPE_REDIS_NO_PERSISTENCE - - use Redis with turned off save option and turned off appendonly

#Testing

Run docker-compose with specified count of consumers and producers

```
docker-compose up --scale php-consumer=5 --scale php-producers=5
```

Example resulr

![result](https://i.imgur.com/ucvZp1o.png)
