<?php


namespace App\Controller\Web;

use App\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function index()
    {
        return $this->sendResponse();
    }
}