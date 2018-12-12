<?php

namespace App\Http\Controllers\Admin\Config;

use App\Models\Orm\Banner;
use App\Models\Orm\BannerLinkType;
use App\Models\Orm\BannerType;
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


    /**编辑
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = Banner::findOrFail($id);

        return view('admin.config.bannerconfig.edit', compact('user'));
    }

    /**修改
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $link_type = BannerLinkType::get()->toArray();
        $banner_type = BannerType::get()->toArray();

        return view('admin.config.bannerconfig.create',compact('link_type','banner_type'));
    }

    /**保存
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $role = Banner::create([
            'banner_name' => $request->input('banner_name'),
            'banner_type_id' => $request->input('banner_type_id'),
            'position' => $request->input('position'),
            'img_address' => $request->input('img_address'),
            'img_href' => $request->input('img_href'),
            'link_type' => $request->input('link_type'),
            'status' => $request->input('status'),
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('admin.bannerconfig.index')->with('success', '添加成功！');
    }


    /**删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $borrow = Banner::where('id', $id)->findOrFail($id);
        $borrow->delete();

        return redirect()->route('admin.bannerconfig.index')->with('success', '删除成功！');
    }

}
