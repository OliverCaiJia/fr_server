<?php

namespace App\Models\Chain\Order\PayOrder\UserExtraOrder;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\FreeProductFactory;
use App\Models\Factory\Api\UserFreeProductFactory;

class CreateUserFreeProductAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建免费产品失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
        $this->data = $params;
    }

    public function handleRequest()
    {
        $freeProduct = FreeProductFactory::getFreeProductByNid($this->params['extra_type_nid']);
        if (empty($freeProduct)) {
            $this->error = ['error' => '未找到对应免费产品', 'code' => 12306];
            return $this->error;
        }
        $userFreeProduct['user_id'] = $this->params['user_id'];
        $userFreeProduct['order_id'] = $this->params['order_id'];
        $userFreeProduct['free_product_id'] = $freeProduct['id'];
        $userFreeProduct['create_at'] = date('Y-m-d H:i:s');
        $userFreeProduct['update_at'] = date('Y-m-d H:i:s');
        $result = UserFreeProductFactory::createUserFreeProduct($userFreeProduct);

        if ($result) {
            return $this->data;
        }
        return $this->error;
    }
}
