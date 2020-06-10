<?php


namespace App\Repositories\Test;


use App\Model\Test\TestModel;
use App\Repositories\BaseRepository;

class TestRepositories extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return TestModel::class;
    }
}