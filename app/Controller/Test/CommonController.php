<?php


namespace App\Controller\Test;

use App\Librarys\Redis;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class CommonController extends Controller
{
    /**
     * 查看异常信息
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function error(RequestInterface $request, ResponseInterface $response)
    {
        $uuid = $request->route('id', 0);
        $error = Redis::getExceptionRedisConnection()->get('system_error_' . $uuid);
        return $response->raw($error);
    }
}