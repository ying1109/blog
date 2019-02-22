<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends CommonController
{
    // 测试数据库是否连接成功
    public function connectionSql() {
        $pdo = DB::connection()->getPdo();
        dd($pdo);
    }

    // 打印服务器系统常量
    public function server() {
        // dd($_SERVER);
        phpinfo();
    }

    // 密码
    public function crypt() {
        $str = '123456';

        echo Crypt::encrypt($str);
    }


}
