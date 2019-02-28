<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
    // get.admin/category（全部分类列表）
    public function index() {
        // $categorys = Category::tree();
        $categorys = (new Category)->tree();

        return view('admin.category.index')->with('data', $categorys);
    }

    public function changeOrder() {
        $input            = Input::all();
        $cate             = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $res              = $cate->update();
        if ($res) {
            $data = array(
                'status' => 1,
                'msg'    => '分类排序更新成功！',
            );
        } else {
            $data = array(
                'status' => 0,
                'msg'    => '分类排序更新失败，请稍后重试！',
            );
        }

        return $data;
    }

    // post.admin/category
    public function store() {

    }

    // get.admin/category/create （添加分类）
    public function create() {

    }

    // get.admin/category/{category} （显示单个分类信息）
    public function show() {

    }

    // delete.admin/category/{category} （删除单个分类）
    public function destroy() {

    }

    // put.admin/category/{category} （更新分类）
    public function update() {

    }

    // get.admin/category/{category}/edit （编辑分类）
    public function edit() {

    }


}
