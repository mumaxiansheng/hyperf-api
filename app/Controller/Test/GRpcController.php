<?php


namespace App\Controller\Test;


use App\Grpc;
use Grpc\HiUser;
use Hyperf\HttpServer\Contract\ResponseInterface;

class GRpcController extends Controller
{
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    public function index()
    {
        $client = new Grpc\TestClient('127.0.0.1:9503', [
            'credentials' => null,
        ]);

        $request = new HiUser();
        $request->setName('hyperf');
        $request->setSex(1);

        list($reply, $status) = $client->test($request);
        $message = $reply->getMessage();
        $user = $reply->getUser();
        $client->close();

        $data = [
            'message' => $message,
            'name' => $user->getName(),
            'sex' => $user->getSex(),
            'status' => $status,
        ];

        return $this->sendResponse($data);
    }
}