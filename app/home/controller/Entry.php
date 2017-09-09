<?php
//命名空间
//命名空间按照 路径起名 方便查找
namespace app\home\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Article;
//声明一个类 继承控制类
// 用于测试访问app中构建的程序
class Entry extends Controller {
//    创建index函数
    public function index(){
//        include 'sss';
//        检测这些方法是否能够执行
//        $this->message("dsad");
//        $test = 'houdunwang';
//       View::with('dsada');
//       return  View::make()->with(compact('test'));
//        dd(compact('a'));
//             把通过find方法查询到的数据赋值给$data
      $data =Article::find(1);
//      把数据打印出来
        dd($data);
    }

    public function add(){

    }

}


