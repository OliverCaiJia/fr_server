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
