<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    // get.admin/navs（全部自定义导航列表）
    public function index() {
        $data = Navs::orderBy('nav_order', 'asc')->get();

        return view('admin.navs.index', compact('data'));
    }

    public function changeOrder() {
        $input           = Input::all();
        $navs            = Navs::find($input['nav_id']);
        $navs->nav_order = $input['nav_order'];
        $res             = $navs->update();
        if ($res) {
            $data = array(
                'status' => 1,
                'msg'    => '自定义导航排序更新成功！',
            );
        } else {
            $data = array(
                'status' => 0,
                'msg'    => '自定义导航排序更新失败，请稍后重试！',
            );
        }

        return $data;
    }

    // get.admin/navs/create （添加自定义导航）
    public function create() {

        return view('admin/navs/add');
    }

    // post.admin/navs （添加自定义导航提交）
    public function store() {
        $input = Input::except('_token');

        $rules   = array(
            'nav_name' => 'required',
            'nav_url'  => 'required',
        );
        $massage = array(
            'nav_name.required' => '自定义导航名称不能为空！',
            'nav_url.required'  => '自定义导航URL不能为空！',
        );

        $validoter = Validator::make($input, $rules, $massage);

        if ($validoter->passes()) {
            $res = Navs::create($input);
            if ($res) {
                return redirect('admin/navs');
            } else {
                return back()->with('errors', '自定义导航添加失败，请稍后重试！');
            }
        } else {

            return back()->withErrors($validoter);
        }
    }

    // get.admin/navs/{navs}/edit （编辑自定义导航）
    public function edit($nav_id) {
        $field = Navs::find($nav_id);

        return view('admin.navs.edit', compact('field'));
    }

    // put.admin/navs/{navs} （更新自定义导航）
    public function update($nav_id) {
        $input = Input::except('_token', '_method');
        $res   = Navs::where('nav_id', $nav_id)->update($input);
        if ($res) {
            return redirect('admin/navs');
        } else {
            return back()->with('errors', '自定义导航信息更新失败，请稍后重试！');
        }
    }

    // delete.admin/navs/{navs} （删除单个自定义导航）
    public function destroy($nav_id) {
        $res = Navs::where('nav_id', $nav_id)->delete();

        if ($res) {
            $data = array(
                'status' => 1,
                'msg'    => '自定义导航删除成功！',
            );
        } else {
            $data = array(
                'status' => 0,
                'msg'    => '自定义导航删除失败，请稍后重试！',
            );
        }

        return $data;
    }


    // get.admin/category/{category} （显示单个分类信息）
    public function show() {

    }


}
