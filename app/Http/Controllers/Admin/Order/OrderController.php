<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserOrderTypeFactory;
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
        //接收参数
        $start = $request->input('start');
        $end = $request->input('end');
        $mobile = $request->input('mobile');
        $order_type = $request->input('order_type');
        $order_status = $request->input('order_status');

        $query = new UserOrder();

        if ($order_status || $order_status === '0') {
            $query = $query->where('status', $order_status);
        }

        //根据用户手机号获取用户id
        $user_id = UserAuthFactory::getUserIdByMobile($mobile);

        $type = UserOrderTypeFactory::getOrderTypeNidLists();

        $query = $query->when($start, function ($query) use ($start, $end) {
            return $query->whereBetween('create_at', [$start, $end]);
        })->when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        })->when($order_type, function ($query) use ($order_type) {
            return $query->where('order_type', $order_type);
        })->orderBy('id', 'desc')->paginate(10);

        return view('admin.order.order.index', compact('query', 'type'));
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $user = UserOrder::findOrFail($id);

        return view('admin.order.order.edit', compact('user'));
    }

    /**
     * 更新用户信息
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param                                $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $user = UserOrder::findOrFail($id);
        $userData = [
            'status' => $request->input('status'),
            'order_expired' => $request->input('order_expired'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.order.index', ['id' => $id])->with('success', '修改成功');
    }
}
