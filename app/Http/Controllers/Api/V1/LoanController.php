<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Controller;
use App\Models\Factory\Api\ProductFactory;
use App\Models\Orm\Product;
use Illuminate\Http\Request;

class LoanController extends Controller
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