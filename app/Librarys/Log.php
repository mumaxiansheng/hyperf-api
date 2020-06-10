<?php

namespace App\Librarys;

use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * 日志类库
 * Class Log
 * @package App\Librarys
 */
class Log
{
    /**
     * 记录日志
     * @param string $flag 日志标识
     * @param string $message 日志信息
     * @param array $data 日志数据
     * @param int $logLevel 错误等级
     * @param string $fileName 日志文件名
     * @param string $pathName 日志路径
     * @throws \Exception
     */
    public static function recordLog($flag, $message, $data = [], $logLevel = LOG_INFO, $fileName = 'system', $pathName = '')
    {
        $log = new Logger($flag);
        $path = BASE_PATH . '/runtime/logs/' . date('Ym') . '/';
        if ($pathName) {
            $path .= $pathName . '/';
        }
        $logPath = $path . date('d') . '-' . $fileName . '.log';
        //判断错误等级
        switch ($logLevel) {
            case LOG_INFO:
                $level = Logger::INFO;
                break;
            case LOG_DEBUG:
                $level = Logger::DEBUG;
                break;
            case LOG_ERR:
                $level = Logger::ERROR;
                break;
            default:
                $level = Logger::INFO;
        }
        $stream = new StreamHandler($logPath, $level);
        $fire = new FirePHPHandler();
        $log->pushHandler($stream);
        $log->pushHandler($fire);
        $log->log($level, $message, $data);
        return;
    }

    /**
     *普通日志
     * @param string $flag 日志标识
     * @param string $message 日志信息
     * @param array $data 日志数据
     * @param int $logLevel 错误等级
     * @throws \Exception
     */
    public static function customLog($flag, $message, $data = [], $logLevel = LOG_INFO)
    {
        $className = self::getLatestCalledClass(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1));
        self::recordLog($flag, $message, $data, $logLevel, $fileName ?? $className, $pathName ?? $className);
    }

    /**
     * @param array $trace
     * @return mixed|string
     */
    public static function getLatestCalledClass(array $trace)
    {
        $classFullyName = $trace[0]['file'];
        $classFullyName = str_replace('.php', '', $classFullyName);
        $classFullyNameArr = explode('/', $classFullyName);
        return array_pop($classFullyNameArr);
    }
}