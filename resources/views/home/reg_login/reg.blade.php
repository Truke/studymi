<?php
/**
 * File Name: reg.blade.php
 * Description:前台会员登陆
 * Created by PhpStorm.
 * Auth: Long
 * Date: 2017/6/28 0028
 * Time: 下午 10:54
 */
?>
@extends('layouts.iframe')
@section('title', '注册')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/home/mi_reg/layout.css') }}">
@endsection
@section('content')
    <div class="zhuti">
        <div class="tou">
            <img class="logo" src="{{url('images/home/logo.png')}}">
        </div>

        <div class="biao">
            <h6 class="zi">注册小米账号</h6>
        </div>
        <div class="layui-tab layui-tab-card" lay-filter="demo">
            <div class="layui-tab-content" style="height: 500px;">
                <div class="layui-tab-item layui-show" style="">
                    <div class="shu layui-form">
                        <div class="xiao layui-form">
                            <form class="layui-form" action="{{url('reg')}}" method="post">
                            {{csrf_field()}}
                            <input type="text" name="phone" required lay-verify="required|phone|number" placeholder="请输入手机号码"
                                   autocomplete="off" class="layui-input qing" value="{{old('phone')}}">
                                <span class="code">{{$errors->first('phone')}}</span>
                            <input type="text" name="email" required lay-verify="required|email" placeholder="请输入邮箱地址"
                                   autocomplete="off" class="layui-input qing">
                                <span class="code">{{$errors->first('email')}}</span>
                            <input type="password" id="pass" name="password" required lay-verify="required|pass" placeholder="请输入密码"
                                   autocomplete="off" class="layui-input qing" value="{{old('password')}}">
                            <input type="password" name="password_confirmation" required lay-verify="required" placeholder="请再次输入密码"
                                   autocomplete="off" class="layui-input qing" value="{{old('password_confirmation')}}">
                            <div class="code">{{$errors->first('password')}}</div>
                            <div style="display: inline-table;clear:both;">
                                <input type="text" id="verify" name="code" required lay-verify="required" placeholder="请输入图片验证码"
                                       autocomplete="off" class="layui-input qing" style="width:200px" value="{{old('code')}}">
                            </div>
                            <a onclick="javascript:re_captcha();">
                                <img src="{{ url('/kit/captcha/1') }}" alt="验证码" title="刷新图片" width="100"
                                     height="40" id="code" border="1"
                                     style="float:right;margin-top: 20px;">
                            </a>
                                <div class="code">{{session('error')?session('error'):''}}</div>
                                <input type="submit" value="立即注册" class="liji">
                            </form>


                            <div class="dian">
                                点击“立即注册”，即表示您同意并愿意遵守小米<b class="dian-1"><a href=""> 用户协议 </a></b> 和<b class="dian-2"><a
                                            href=""> 隐私政策</a></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="weizi">
                <a href="" class="ziyi">简体</a> |
                <a href="" class="fan">繁体</a> |
                <a href="" class="yinyu">English</a> |
                <a href="" class="chang">常见问题</a>
            </div>
            <div class="gong">
                小米公司版权所有-京ICP备案1004644-<span class="gong-1"><img
                            src="./img/ghs.png">京公网安备11010802020134号-京ICP证110507号</span>
            </div>
        </div>
    </div>
@endsection
@section('js')
                @parent
                <script>
                    function re_captcha() {
                        $url = "{{ URL('kit/captcha') }}";
                        $url = $url + "/" + Math.random();
                        document.getElementById('code').src = $url;
                    }

                    layui.use(['layer', 'element', 'jquery', 'form'], function () {

                        var $ = layui.jquery
                            , layer = layui.layer
                            , laypage = layui.laypage
                            , element = layui.element()
                            , form = layui.form();

                        $('input[name=password_confirmation]').blur(function () {

                            var password = $(this).prev('#pass').val();
                            var pass = $(this).val();
                            var str = "<div style='color:red' id='deng'>输入的密码不一致</div>";
                            if (password != pass) {
                                $('#deng').remove();
                                $(this).after(str)
                                form.on('submit(go)', function () {
                                    layer.msg('密码请保持一致');
                                    return false;
                                })
                            } else {
                                $('#deng').remove();
                            }
                        });
                    });
                </script>
@endsection
