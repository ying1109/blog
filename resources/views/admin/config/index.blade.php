@extends('layouts.admin')
@section('content')

<!--面包屑配置项 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项管理
</div>
<!--面包屑配置项 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <div class="result_title">
            <h3>配置项列表</h3>
        </div>
        <!--快捷配置项 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
        <!--快捷配置项 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">排序</th>
                    <th class="tc" width="5%">ID</th>
                    <th>配置项名称</th>
                    <th>配置项别名</th>
                    <th>配置项地址</th>
                    <th>操作</th>
                </tr>

                @foreach ($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this, {{$v->nav_id}})" value="{{$v->nav_order}}">
                        </td>
                        <td class="tc">{{$v->nav_id}}</td>
                        <td>
                            <a href="#">{{$v->nav_name}}</a>
                        </td>
                        <td>{{$v->nav_alias}}</td>
                        <td>{{$v->nav_url}}</td>
                        <td>
                            <a href="{{url('admin/config/' . $v->nav_id .'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delconfig({{$v->nav_id}})">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->
    
<script type="text/javascript">
    function changeOrder(obj, nav_id) {
        var nav_order = $(obj).val();
        $.post('{{url('admin/config/changeOrder')}}', {'_token':'{{csrf_token()}}', 'nav_id':nav_id, 'nav_order':nav_order}, function (data) {
            if (data.status) {
                layer.alert(data.msg, {icon: 6});
            } else {
                layer.msg(data.msg, {icon: 5});
            }
        });
    }

    // 删除配置项
    function delconfig(nav_id) {
        //询问框
        layer.confirm('您确定要删除这个配置项吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/config/')}}/" + nav_id, {'_method':'delete', '_token':"{{csrf_token()}}"}, function (data) {
                if (data.status == 1) {
                    layer.alert(data.msg, {icon: 6});
                    // 刷新当前页面
                    location.href = location.href;
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            });

            // layer.msg('的确很重要', {icon: 1});
        }, function(){

        });
    }

</script>

@endsection