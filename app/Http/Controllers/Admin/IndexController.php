<?php

namespace App\Http\Controllers\Admin;

// use Dotenv\Validator;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Types\Array_;

class IndexController extends CommonController {
    public function index() {

        return view('admin.index');
    }

    public function info() {

        return view('admin.info');
    }

    // 修改超级管理员密码
    public function pass() {
        if ($input = Input::all()) {
            $rules   = array(
                'password' => 'required|between:6,20|confirmed',
            );
            $massage = array(
                'password.required'  => '新密码不能为空！',
                'password.between'   => '新密码必须在6-20位之间！',
                'password.confirmed' => '新密码和确认密码不一致！',
            );

            $validoter = Validator::make($input, $rules, $massage);

            if ($validoter->passes()) {
                $user      = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if ($input['password_o'] == $_password) {
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors', '密码修改成功！');
                } else {
                    return back()->with('errors', '原密码错误！');
                }
            } else {

                return back()->withErrors($validoter);
            }
        } else {
            return view('admin.pass');
        }

    }


}
