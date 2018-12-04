<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserLoanTask;
use App\Http\Controllers\Admin\User\ViewController;
use Illuminate\Http\Request;

class UserTaskController extends ViewController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = UserLoanTask::orderBy('id', 'desc')->paginate(10);

        return view('admin.users.usertask.index', compact('query'));
    }


    /**详情
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $task = UserLoanTask::where('id', $id)->findOrFail($id);
        $request_data = json_decode($task->request_data,true);
        $retrieve_req_data = json_decode($task->retrieve_rsp_data,true);

        return view('admin.users.usertask.edit', compact('request_data','retrieve_req_data'
            ));
    }

}
