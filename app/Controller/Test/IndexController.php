<?php


namespace App\Controller\Test;


use App\Repositories\Test\TestRepositories;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

/**
 * 测试示例类
 * Class IndexController
 * @package App\Controller\Test
 */
class IndexController extends Controller
{
    /**
     * 资源
     * @var TestRepositories
     */
    protected $repository;

    /**
     * 验证器
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * IndexController constructor.
     * @param ResponseInterface $response
     * @param TestRepositories $repositories
     * @param ValidatorFactoryInterface $validationFactory
     */
    public function __construct(ResponseInterface $response, TestRepositories $repositories, ValidatorFactoryInterface $validationFactory)
    {
        parent::__construct($response);
        $this->repository = $repositories;
        $this->validationFactory = $validationFactory;
    }

    /**
     * 获取列表
     * @return mixed
     */
    public function index()
    {
        $res = $this->repository->getList();
        return $this->sendResponse($res);
    }

    /**
     * 添加数据
     * @param RequestInterface $request
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function store(RequestInterface $request)
    {
        $requestData = $request->all();

        //验证数据格式
        $validator = $this->validationFactory->make(
            $requestData,
            [
                'name' => 'required|max:10',
            ],
            __('validation.test')
        );

        //数据格式不正确返回错误信息
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return $this->sendResponse($errorMessage, 400);
        }

        $this->repository->create($requestData);

        return $this->sendResponse();
    }

    /**
     * 获取详情
     * @param $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function show($id)
    {
        $res = $this->repository->find($id);
        if (empty($res)) {
            return $this->sendResponse(__('msg.404'), 404);
        }
        return $this->sendResponse($res);
    }

    /**
     * 更新
     * @param RequestInterface $request
     * @param $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function update(RequestInterface $request, $id)
    {
        $requestData = $request->all();

        //验证数据格式
        $validator = $this->validationFactory->make(
            $requestData,
            [
                'name' => 'required|max:10',
            ],
            __('validation.test')
        );

        //数据格式不正确返回错误信息
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return $this->sendResponse($errorMessage, 400);
        }
        $this->repository->update($requestData, $id);

        return $this->sendResponse();
    }

    /**
     * 移除数据
     * @param $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return $this->sendResponse();
    }
}