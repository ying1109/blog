<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    // get.admin/config（全部配置项列表）
    public function index() {
        $data = Config::orderBy('conf_order', 'asc')->get();

        return view('admin.config.index', compact('data'));
    }

    public function changeOrder() {
        $input              = Input::all();
        $config             = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $res                = $config->update();
        if ($res) {
            $data = array(
                'status' => 1,
                'msg'    => '配置项排序更新成功！',
            );
        } else {
            $data = array(
                'status' => 0,
                'msg'    => '配置项排序更新失败，请稍后重试！',
            );
        }

        return $data;
    }

    // get.admin/config/create （添加配置项）
    public function create() {

        return view('admin/config/add');
    }

    // post.admin/config （添加配置项提交）
    public function store() {
        $input = Input::except('_token');

        $rules = array(
            'conf_name'  => 'required',
            'conf_title' => 'required',
        );
        $massage = array(
            'conf_name.required'  => '配置项名称不能为空！',
            'conf_title.required' => '配置项标题不能为空！',
        );

        $validoter = Validator::make($input, $rules, $massage);

        if ($validoter->passes()) {
            $res = Config::create($input);
            if ($res) {
                return redirect('admin/config');
            } else {
                return back()->with('errors', '配置项添加失败，请稍后重试！');
            }
        } else {

            return back()->withErrors($validoter);
        }
    }

    // get.admin/config/{config}/edit （编辑配置项）
    public function edit($conf_id) {
        $field = Config::find($conf_id);

        return view('admin.config.edit', compact('field'));
    }

    // put.admin/config/{config} （更新配置项）
    public function update($conf_id) {
        $input = Input::except('_token', '_method');
        $res   = Config::where('conf_id', $conf_id)->update($input);
        if ($res) {
            return redirect('admin/config');
        } else {
            return back()->with('errors', '配置项信息更新失败，请稍后重试！');
        }
    }

    // delete.admin/config/{config} （删除单个配置项）
    public function destroy($conf_id) {
        $res = Config::where('conf_id', $conf_id)->delete();

        if ($res) {
            $data = array(
                'status' => 1,
                'msg'    => '配置项删除成功！',
            );
        } else {
            $data = array(
                'status' => 0,
                'msg'    => '配置项删除失败，请稍后重试！',
            );
        }

        return $data;
    }


    // get.admin/category/{category} （显示单个分类信息）
    public function show() {

    }


}
