<?php

namespace App\Http\Controllers\Qudao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QudaoController extends Controller
{
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout($data = [])
    {
        if (!is_null($this->layout)) {
            $this->layout = view($this->layout, $data);
        }
    }


    /**
     * 获取请求参数
     * @param Request $request
     * @return type
     */
    public function getResponses(Request $request)
    {
        $responses['draw'] = $request->input('draw');
        $responses['length'] = $request->input('length', 30) ?: 30;                                                                          // 每页显示数据
        $responses['start'] = $request->input('start', 0) ?: 0;                                                                              // 开始项
        $responses['order'] = $request->input('order', 'id') ?: 'id';
        $responses['columns'] = $request->input('columns', []) ?: [];
        $responses['search'] = $request->input('search', 0) ?: 0;
        $responses['searchField'] = $responses['search'] ? $responses['search']['value'] : '';
        $responses['orderField'] = $responses['columns'][current($responses['order'])['column']]['data'] ?: 'id';                           // 排序字段
        $responses['orderDirection'] = current($responses['order'])['dir'] ?: 'desc';                                                       // 排序方式
        $responses['recordsTotal'] = $request->input('recordsTotal', 0) ?: 0;
        $responses['recordsFiltered'] = $request->input('recordsFiltered', 0) ?: 0;
        $responses['data'] = [];

        $responses = array_merge($request->all(), $responses);
        return $responses;
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
