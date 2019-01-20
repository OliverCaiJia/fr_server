<?php

namespace App\Http\Controllers\Admin\Data;

use App\Models\Orm\UserChannel;
use App\Models\Orm\Channel;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use DB;

class ChannelDataController extends AdminController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
//        $channel_title = $request->input('channel_title');

        $query = UserChannel::select('status','id','channel_id','create_at','update_at')
            ->groupBy('channel_id')
            ->orderBy('id', 'desc')->paginate(10);
        return view('admin.data.channeldata.index', compact('query'));
    }


    /**删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $borrow = UserBorrowLog::where('id', $id)->findOrFail($id);
        $borrow->delete();

        return redirect()->route('admin.userborrow.index')->with('success', '删除成功！');
    }

}
