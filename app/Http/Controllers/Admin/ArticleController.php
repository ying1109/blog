<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    // get.admin/article（全部文章列表）
    public function index() {
        echo '全部文章列表';
    }

    // get.admin/article/create （添加文章）
    public function create() {

        $data = (new Category)->tree();
        return view('admin.article.add', compact('data'));
    }

    // post.admin/article （添加文章提交）
    public function store() {
        $input             = Input::except('_token', 'file_upload');
        $input['art_time'] = time();

        $rules = array(
            'art_title'   => 'required',
            'art_content' => 'required',
        );
        $massage = array(
            'art_title.required'  => '文章标题不能为空！',
            'art_content.required'  => '文章内容不能为空！',
        );

        $validoter = Validator::make($input, $rules, $massage);

        if ($validoter->passes()) {
            $res = Article::create($input);
            if ($res) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '数据填充失败，请稍后重试！');
            }
        } else {

            return back()->withErrors($validoter);
        }
    }



}
