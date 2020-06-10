<?php

namespace App\Controller\Api;

use App\Controller\AbstractController;
use Hyperf\HttpServer\Contract\ResponseInterface;

class Controller extends AbstractController
{
    /**
     * 响应资源
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Controller constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * 发送响应
     * @param array|string $data 响应数据
     * @param int $code 响应编码
     * @return mixed
     */
    public function sendResponse($data, $code = 0)
    {
        $responseData['code'] = $code;
        if ($code == 0) {
            $responseData['message'] = 'success';
            $responseData['data'] = $data;
        } else {
            $responseData['message'] = $data;
        }
        return $this->response->withStatus(200)->json($responseData);
    }
}