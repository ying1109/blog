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


        $data = Article::orderBy('art_id', 'desc')->paginate(3);

        return view('admin.article.index', compact('data'));
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

    // get.admin/article/{article}/edit （编辑文章）
    public function edit($art_id) {


        $data = (new Category)->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit', compact('field', 'data'));
    }

    // put.admin/article/{article} （更新文章）
    public function update($art_id) {
        $input = Input::except('_token', '_method');
        $res   = Article::where('art_id', $art_id)->update($input);
        if ($res) {
            return redirect('admin/article');
        } else {
            return back()->with('errors', '文章信息更新失败，请稍后重试！');
        }
    }

    // delete.admin/article/{article} （删除单个分类）
    public function destroy($art_id) {
        $res = Article::where('art_id', $art_id)->delete();
        if ($res) {
            $data = array(
                'status' => 1,
                'msg'    => '文章删除成功！',
            );
        } else {
            $data = array(
                'status' => 0,
                'msg'    => '文章删除失败，请稍后重试！',
            );
        }

        return $data;
    }



}
