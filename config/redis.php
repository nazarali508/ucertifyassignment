<?php
class RedisCache {
    private $redis;

    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function set($key, $value, $ttl = 3600) {
        $this->redis->setex($key, $ttl, $value);
    }

    public function get($key) {
        return $this->redis->get($key);
    }

    public function delete($key) {
        $this->redis->del($key);
    }
}
