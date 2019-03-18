<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    // get.admin/links（全部友情链接列表）
    public function index() {
        $data = Links::orderBy('link_order', 'asc')->get();

        return view('admin.links.index', compact('data'));
    }

    public function changeOrder() {
        $input             = Input::all();
        $links             = Links::find($input['link_id']);
        $links->link_order = $input['link_order'];
        $res               = $links->update();
        if ($res) {
            $data = array(
                'status' => 1,
                'msg'    => '友情链接排序更新成功！',
            );
        } else {
            $data = array(
                'status' => 0,
                'msg'    => '友情链接排序更新失败，请稍后重试！',
            );
        }

        return $data;
    }

    // get.admin/links/create （添加友情链接）
    public function create() {

        return view('admin/links/add');
    }

    // post.admin/links （添加友情链接提交）
    public function store() {
        $input = Input::except('_token');

        $rules   = array(
            'link_name' => 'required',
            'link_url'  => 'required',
        );
        $massage = array(
            'link_name.required' => '友情链接名称不能为空！',
            'link_url.required'  => '友情链接URL不能为空！',
        );

        $validoter = Validator::make($input, $rules, $massage);

        if ($validoter->passes()) {
            $res = Links::create($input);
            if ($res) {
                return redirect('admin/links');
            } else {
                return back()->with('errors', '友情链接添加失败，请稍后重试！');
            }
        } else {

            return back()->withErrors($validoter);
        }
    }

    // get.admin/links/{links}/edit （编辑友情链接）
    public function edit($link_id) {
        $field = Links::find($link_id);

        return view('admin.links.edit', compact('field'));
    }

    // put.admin/links/{links} （更新友情链接）
    public function update($link_id) {
        $input = Input::except('_token', '_method');
        $res   = Links::where('link_id', $link_id)->update($input);
        if ($res) {
            return redirect('admin/links');
        } else {
            return back()->with('errors', '友情链接信息更新失败，请稍后重试！');
        }
    }

    // delete.admin/links/{links} （删除单个友情链接）
    public function destroy($link_id) {
        $res = Links::where('link_id', $link_id)->delete();

        if ($res) {
            $data = array(
                'status' => 1,
                'msg'    => '友情链接删除成功！',
            );
        } else {
            $data = array(
                'status' => 0,
                'msg'    => '友情链接删除失败，请稍后重试！',
            );
        }

        return $data;
    }


    // get.admin/category/{category} （显示单个分类信息）
    public function show() {

    }


}
