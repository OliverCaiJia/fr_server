<?php

namespace App\Http\Controllers\Admin\Config;

use App\Models\Orm\Channel;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class ChannelConfigController extends AdminController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $channel_nid = $request->input('channel_nid');

        $query = Channel::when($channel_nid, function ($query) use ($channel_nid) {
            return $query->where('channel_nid', $channel_nid);
        })->orderBy('id', 'desc')->paginate(10);

        return view('admin.config.channelconfig.index', compact('query'));
    }


    /**编辑
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = Channel::findOrFail($id);

        return view('admin.config.channelconfig.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = Channel::findOrFail($id);
        $userData = [
            'channel_nid' => $request->input('channel_nid'),
            'channel_title' => $request->input('channel_title'),
            'status' => $request->input('status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.channelconfig.index', ['id' => $id])->with('success', '修改成功');
    }

    /**添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.config.channelconfig.create');
    }

    /**保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $role = Channel::create([
            'channel_nid' => $request->input('channel_nid'),
            'channel_title' => $request->input('channel_title'),
            'channel_des' => $request->input('channel_des'),
            'status' => $request->input('status'),
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('admin.channelconfig.index')->with('success', '添加成功！');
    }

    public function destroy($id)
    {
        $borrow = Channel::where('id', $id)->findOrFail($id);
        $borrow->delete();

        return redirect()->route('admin.channelconfig.index')->with('success', '删除成功！');
    }

}
