<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 测试控制器
 */
class TestController extends Controller
{

    /**
     * 测试方法--学习练习
     *
     * @return void
     */
    public function test(Request $request)
    {
        //获取当前请求URL地址
        dump($request->fullUrl());

        //
        dump($request->url());

        //获取当前请求路径部分
        dump($request->path());

        //获取当前请求方式
        dump($request->method());
        //判断当前请求是什么请求
        dump($request->isMethod('post'));
        dump($request->isMethod('get'));

        //判断当前请求是否是request请求
        dump($request->is('request'));
    }


    /**
     * 文件上传
     *
     * @param Request $request
     * @return void
     */
    public function upload(Request $request)
    {
        //判断是否有文件
        if (!$request->hasFile('theme')) {
            return '没有上传文件，请检查';
        }
        //接收文件
        $file = $request->file('theme');
        //判断文件是否上传成功
        if ($request->file('theme')->isValid()) {
            //获取文件名
            dump($file->hashName());
            //获取文件后缀名
            dump($file->extension());
            //获取文件路径
            dump($file->path());
        }
    }
}
