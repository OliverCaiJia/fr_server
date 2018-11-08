<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * 基础信息 —— 推荐产品列表
     */
    public function products()
    {
        $data = [['product_id' => 1,
            'platform_product_name' => '速贷之家',
            'product_log' => 'img_url',
            'product_introduct' => '产品描述']];
        return RestResponseFactory::ok($data);
    }
}