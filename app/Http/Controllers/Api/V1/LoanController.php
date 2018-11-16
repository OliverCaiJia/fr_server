<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\ProductFactory;
use Illuminate\Http\Request;

class LoanController extends ApiController
{
    /**
     * 基础信息 —— 推荐产品列表
     */
    public function products()
    {
        $data = ProductFactory::getLoadProducts();
        return RestResponseFactory::ok($data);
    }
}