<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Orm\UserOrder;
use Illuminate\Http\Request;
use Excel;

class OrderController extends AdminController
{


    /**
     * 订单记录
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $query =UserOrder::orderBy('id', 'desc')->paginate(10);

        return view('admin.order.order.index', compact('query'));
    }

}
