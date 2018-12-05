<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class AdminController extends Controller
{
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout($data = [])
    {
        if (!is_null($this->layout))
        {
            $this->layout = view($this->layout, $data);
        }
    }

    /**
     * 获取请求参数
     * @param Request $request
     * @return type
     */
    public function getRequests(Request $request)
    {
        $requests['pageSize'] = $request->input('pageSize', 30) ?: 30;                                  // 每页显示数据
        $requests['pageCurrent'] = $request->input('pageCurrent', 1) ?: 1;                              // 当前页面
        $requests['orderField'] = $request->input('orderField', 'id') ?: 'id';                         // 排序字段
        $requests['orderDirection'] = $request->input('orderDirection', 'desc') ?: 'desc';                 // 排序方式
        $requests['total'] = $request->input('total', 0) ?: 0;                                            // 总数
        $requests = array_merge($request->all(), $requests);
        return $requests;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return redirect('/admin/home');
    }

    /**
     * 主页
     * @return type
     */
    public function home()
    {
        return view('vendor.bjui.partials.home');
    }
}
