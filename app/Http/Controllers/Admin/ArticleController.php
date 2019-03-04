<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends CommonController
{
    // get.admin/article（全部文章列表）
    public function index() {
        echo '全部文章列表';
    }

    // get.admin/article/create （添加文章）
    public function create() {


        $data = array();
        return view('admin.article.add', compact('data'));
}



}
