<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserAuth;
use App\Models\Orm\UserLoanTask;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class UserTaskController extends AdminController
{
    /**
     * 用户贷款页.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $mobile = $request->input('mobile');
        $username = $request->input('user_name');

        $userIds = $query = UserAuth::when($username, function ($query) use ($username) {
            return $query->where('user_name', $username);
        })->pluck('id');

        $query = new UserLoanTask();
        if ($userIds) {
            $query = $query->whereIn('user_id', $userIds);
        }
        $query = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.users.usertask.index', compact('query'));
    }

    /**
     * 详情
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $task = UserLoanTask::where('id', $id)->findOrFail($id);
        $request_data = json_decode($task->request_data, true);
        $retrieve_req_data = json_decode($task->retrieve_rsp_data, true);

        return view('admin.users.usertask.edit', compact(
            'request_data',
            'retrieve_req_data'
        ));
    }
}
