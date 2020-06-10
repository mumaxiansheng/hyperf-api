<?php
declare(strict_types=1);

namespace App\Model\Base;


use App\Model\Model;

class BaseModel extends Model
{
    /**
     * 定义库
     * @var string
     */
    protected $connection = 'base';
}