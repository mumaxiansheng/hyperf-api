<?php


namespace App\Repositories;

/**
 * 资源基础类
 * Class BaseRepository
 * @package App\Repositories
 */
class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * 构建模型
     * @return mixed
     */
    public function makeModel()
    {
        $model = make($this->model());
        return $this->model = $model;
    }

    /**
     * 重置模型
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * 查询一条数据
     * @param array $where 查询条件
     * @param string[] $columns 查询字段
     * @param string $orderBy 排序
     * @return mixed
     */
    public function first(array $where = [], $columns = ['*'], $orderBy = '')
    {
        $obj = $this->model->query()->where($where);
        if ($orderBy) {
            foreach ($orderBy as $k => $value) {
                if (is_array($value)) {
                    $obj->orderBy(key($value), array_values($value)[0]);
                } else {
                    $obj->orderBy($value, 'desc');
                }
            }
        }
        return $obj->first($columns);
    }

    /**
     * 根据主键获取
     * @param int $id 主键id
     * @param string[] $columns 获取的字段
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->query()->find($id, $columns);
    }

    /**
     * 获取资源列表
     * @param array $where 查询条件
     * @param string[] $columns 获取的字段
     * @param string $orderBy 排序
     * @return mixed
     */
    public function getList(array $where = [], $columns = ['*'], $orderBy = '')
    {
        $obj = $this->model->query()->where($where);
        if ($orderBy) {
            foreach ($orderBy as $k => $value) {
                if (is_array($value)) {
                    $obj->orderBy(key($value), array_values($value)[0]);
                } else {
                    $obj->orderBy($value, 'desc');
                }
            }
        }
        return $obj->get($columns);
    }

    /**
     * 分页查询
     * @param array $where 查询条件
     * @param int $limit 每页条数
     * @param string[] $columns 查询的字段
     * @param array $orderBy 排序
     * @return mixed
     */
    public function paginate($where = [], $limit = 10, $columns = ['*'], $orderBy = [])
    {
        $obj = $this->model->query()->where($where);
        if ($orderBy) {
            foreach ($orderBy as $k => $value) {
                if (is_array($value)) {
                    $obj->orderBy(key($value), array_values($value)[0]);
                } else {
                    $obj->orderBy($value, 'desc');
                }
            }
        }
        return $obj->paginate($limit, $columns);
    }

    /**
     * 创建
     * @param array $attributes 保存的数据
     * @return mixed
     */
    public function create(array $attributes = [])
    {
        $model = $this->model->newInstance($attributes);
        $model->save();
        return $model;
    }

    /**
     * 更新数据
     * @param array $attributes 要更新的数据
     * @param int $id 主键id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $model = $this->find($id);
        //Fill the model with an array of attributes.
        $model->fill($attributes);
        $model->save();
        $this->resetModel();
        return $model;
    }

    /**
     * 根据主键移除
     * @param int $id 主键id
     * @return mixed
     */
    public function delete($id)
    {
        $model = $this->find($id);
        $model->delete();
        $this->resetModel();
        return $model;
    }

    /**
     * 批量更新
     * @param array $where 查询条件
     * @param array $attributes 更新的数据
     * @param string $tableName 数据库表名
     * @return Model
     */
    public function whereUpdate(array $where = [], array $attributes = [], $tableName = '')
    {
        if (!$tableName) {
            $model = $this->model->query();
        } else {
            $model = $this->model->query()->setTable($tableName);
        }
        $model->where($where)->update($attributes);
        $this->resetModel();
        return $model;
    }

    /**
     * 自增
     * @param array $where 查询条件
     * @param string $key 更新字段
     * @param int $num 自增的数量
     * @return mixed
     */
    public function increment(array $where, $key, $num = 1)
    {
        return $this->model->query()->where($where)->increment($key, $num);
    }

    /**
     * 自减
     * @param array $where
     * @param string $key 自减的字段
     * @param int $num 自减的数量
     * @return mixed
     */
    public function decrement(array $where, $key, $num = 1)
    {
        return $this->model->query()->where($where)->decrement($key, $num);
    }
}