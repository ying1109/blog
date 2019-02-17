<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index() {
        // 测试数据库是否连接成功
        $pdo = DB::connection()->getPdo();
        dd($pdo);
    }
}
