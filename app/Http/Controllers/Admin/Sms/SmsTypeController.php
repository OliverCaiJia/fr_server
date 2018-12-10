<?php

namespace App\Http\Controllers\Admin\Sms;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Orm\SmsType;
use Illuminate\Http\Request;
use Excel;

class SmsTypeController extends AdminController
{


    /**
     * 短信类型
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件

        $query = SmsType::orderBy('id', 'desc')->paginate(10);

        return view('admin.sms.smstype.index', compact('query'));
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $user = SmsType::findOrFail($id);

        return view('admin.sms.smstype.edit', compact('user'));
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
        $user = SmsType::findOrFail($id);
        $userData = [
            'message_type_nid' => $request->input('message_type_nid'),
            'message_type_name' => $request->input('message_type_name'),
            'status' => $request->input('status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.smstype.index', ['id' => $id])->with('success', '修改成功');
    }

    /**添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.sms.smstype.create');
    }

    /**保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $role = SmsType::create([
            'message_type_nid' => $request->input('message_type_nid'),
            'message_type_name' => $request->input('message_type_name'),
            'message_type_desc' => $request->input('message_type_desc'),
            'status' => $request->input('status'),
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('admin.smstype.index')->with('success', '添加成功！');
    }

    /**删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $sms = SmsType::where('id', $id)->findOrFail($id);
        $sms->delete();

        return redirect()->route('admin.smstype.index')->with('success', '删除成功！');
    }

}
