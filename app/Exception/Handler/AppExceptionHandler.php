<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use App\Librarys\Log;
use App\Librarys\Redis;
use App\Librarys\WeChatRobot;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    /**
     * 处理异常
     * @param Throwable $throwable
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $uuid = createUuid();
        $code = $throwable->getCode();
        $errMsg = $throwable->getMessage();
        $errLine = $throwable->getLine();
        $errFile = $throwable->getFile();
        $traceMsg = $throwable->getTraceAsString();

        //记录日志
        Log::recordLog('system_' . $uuid, $errMsg . $errLine . $errFile, [], LOG_ERR);
        Log::recordLog('system_' . $uuid, $traceMsg, [], LOG_INFO);

        //异常数据保存redis
        Redis::getExceptionRedisConnection()->setex('system_error_' . $uuid, 43200, $traceMsg);

        //发送报警
        $link = config('app_url') . "/error/" . $uuid;
        $robotContent = "# <font color=\"warning\">错误报警</font>\n> 
            文件路劲：{$errFile}\n> 
            文件行数：{$errLine}\n> 
            错误内容：{$errMsg}\n> 
            [错误详情]({$link})";
        WeChatRobot::getInstance()->send($robotContent);

        $responseData['code'] = $code;
        $responseData['message'] = $errMsg;
        return $response->withStatus(200)->withBody(new SwooleStream(chJsonEncode($responseData)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
