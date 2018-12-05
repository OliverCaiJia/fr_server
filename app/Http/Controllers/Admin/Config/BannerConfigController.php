<?php

namespace App\Http\Controllers\Admin\Config;

use App\Models\Orm\Banner;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class BannerConfigController extends AdminController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Banner::orderBy('id', 'desc')->paginate(10);

        return view('admin.config.bannerconfig.index', compact('query'));
    }


    /**删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = Banner::findOrFail($id);

        return view('admin.config.bannerconfig.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Banner::findOrFail($id);
        $userData = [
            'banner_name'=>$request->input('banner_name'),
            'img_address'=>$request->input('img_address'),
            'img_href'=>$request->input('img_href'),
            'status' => $request->input('status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.bannerconfig.index', ['id' => $id])->with('success', '修改成功');
    }

}
