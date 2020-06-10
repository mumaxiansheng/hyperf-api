<?php


namespace App\Controller\Rpc;


use Grpc\HiReply;
use Grpc\HiUser;

class IndexController
{
    public function test(HiUser $user)
    {
        $user->setName('gRpc:' . $user->getName());
        $message = new HiReply();
        $message->setMessage("Hello World");
        $message->setUser($user);
        return $message;
    }
}