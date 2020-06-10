<?php
declare(strict_types=1);

namespace App\Model\User;


use App\Model\Model;

class BaseModel extends Model
{
    /**
     * @var string
     */
    protected $connection = 'user';
}