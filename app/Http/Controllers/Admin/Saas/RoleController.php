<?php

namespace App\Http\Controllers\Admin\Saas;

use App\Events\OperationLogEvent;
use App\Http\Requests\RoleRequest;
use App\Models\Factory\Admin\Saas\SaasRoleFactory;
use App\Models\Orm\SaasPermission;
use App\Models\Orm\SaasRole;
use App\Http\Controllers\Controller;
use Auth;

class RoleController extends Controller
{
    /**
     * 角色列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = SaasRole::where('saas_auth_id', Auth::user()->saas_auth_id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.role.index', compact('roles'));
    }

    public function edit($id)
    {
        $role = SaasRole::where('saas_auth_id', Auth::user()->saas_auth_id)->findOrFail($id);

        $permissionAll = [];
        $permission = SaasPermission::all()->sortBy('position');
        foreach ($permission as $v) {
            $permissionAll[$v['parent_id']][] = $v;
        }

        $permissions = $role->permissions->pluck('id')->toArray();

        return view('admin.role.edit', compact(
            'role',
            'permissionAll',
            'permissions'
        ));
    }

    public function create()
    {
        $permissionAll = [];
        $permission = SaasPermission::all()->sortBy('position');

        foreach ($permission as $v) {
            $permissionAll[$v['parent_id']][] = $v;
        }

        return view('admin.role.create', compact('permissionAll'));
    }


    public function store(RoleRequest $request)
    {
        $saasAuthId = Auth::user()->saas_auth_id;
        $name = $request->input('name');

        $role = SaasRoleFactory::getIdByNameAndSaasAuthId($name, $saasAuthId);
        if ($role) {
            return redirect()->back()->withErrors(['name' => '角色名已存在']);
        }

        $role = SaasRole::create([
            'name' => $name,
            'description' => $request->input('description'),
            'saas_auth_id' => $saasAuthId
        ]);

        $role->permissions()->attach($request->input('permissions'));
        event(new OperationLogEvent(1, json_encode($role->toArray())));

        return redirect()->route('admin.role.index')->with('success', '添加成功！');
    }

    public function update(RoleRequest $request, $id)
    {
        $saasAuthId = Auth::user()->saas_auth_id;
        $name = $request->input('name');

        $role = SaasRoleFactory::getIdByNameAndSaasAuthId($name, $saasAuthId);
        if ($role && $role->id != $id) {
            return redirect()->back()->withErrors(['name' => '角色名已存在']);
        }

        $role = SaasRole::where('saas_auth_id', $saasAuthId)->findOrFail($id);

        $role->update([
            'name' => $name,
            'description' => $request->input('description')
        ]);

        if ($request->input('permissions')) {
            $role->permissions()->sync($request->input('permissions'));
        } else {
            $role->permissions()->detach();
        }
        event(new OperationLogEvent(3, json_encode($role->toArray())));

        return redirect()->route('admin.role.edit', ['id' => $id])->with('success', '修改成功');
    }

    /**
     * 删除
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $role = SaasRole::where('saas_auth_id', Auth::user()->saas_auth_id)->findOrFail($id);
        $users = $role->persons;
        if (!$users->isEmpty()) {
            return redirect()->route('admin.role.index')->with('error', '删除失败，请先删除关联的用户！');
        }

        $role->permissions()->detach();
        $role->delete();
        event(new OperationLogEvent(2, json_encode($role->toArray())));

        return redirect()->route('admin.role.index')->with('success', '删除成功！');
    }
}
