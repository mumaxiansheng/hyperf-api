<?php


namespace App\Librarys;

use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;

/**
 * redis 类库
 * Class Redis
 * @package App\Librarys
 */
class Redis
{
    /**
     * 获取默认配置
     * @return \Hyperf\Redis\RedisProxy|\Redis|null
     */
    public static function getRedisConnection()
    {
        $container = ApplicationContext::getContainer();
        return $container->get(RedisFactory::class)->get('default');
    }

    /**
     * 获取异常配置
     * @return \Hyperf\Redis\RedisProxy|\Redis|null
     */
    public static function getExceptionRedisConnection()
    {
        $container = ApplicationContext::getContainer();
        return $container->get(RedisFactory::class)->get('exception');
    }

    /**
     * 获取临时配置
     * @return \Hyperf\Redis\RedisProxy|\Redis|null
     */
    public static function getTempRedisConnection()
    {
        $container = ApplicationContext::getContainer();
        return $container->get(RedisFactory::class)->get('temp');
    }

    /**
     * 获取长期库配置
     * @return \Hyperf\Redis\RedisProxy|\Redis|null
     */
    public static function getLongRedisConnection()
    {
        $container = ApplicationContext::getContainer();
        return $container->get(RedisFactory::class)->get('long');
    }
}