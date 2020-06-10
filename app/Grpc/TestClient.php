<?php


namespace App\Grpc;


use Grpc\HiReply;
use Grpc\HiUser;
use Hyperf\GrpcClient\BaseClient;

class TestClient extends BaseClient
{
    public function test(HiUser $argument)
    {
        return $this->simpleRequest(
            '/rpc/test/test',
            $argument,
            [HiReply::class, 'decode']
        );
    }
}