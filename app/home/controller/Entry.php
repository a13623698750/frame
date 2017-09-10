<?php
//命名空间
//命名空间按照 路径起名 方便查找
namespace app\home\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Article;
use system\model\Student;

//声明一个类 继承控制类
// 用于测试访问app中构建的程序
class Entry extends Controller {
//    创建index函数
    public function index(){
//        测试抛出异常加载第三方类库
//        include 'sss';
//        检测这些方法是否能够执行
//        $this->message("dsad");
//        $test = 'houdunwang';
//       View::with('dsada');
//       return  View::make()->with(compact('test'));
//        dd(compact('a'));



//       把通过find方法查询到的数据赋值给$data
      //$data =Article::find(1);
//      把数据打印出来
        //dd($data);
//***************测试数据库根据主键查找单一一条数据***************//
//      测试find方法是否可用
//       Article::find();
//       $data = Article::find(1);//obj
//            dd($data);
//        houdunwang\model\Base Object
//        (
//            [table:houdunwang\model\Base:private] => article
//        [data:houdunwang\model\Base:private] => Array
//        (
//            [aid] => 1
//            [atitle] => 老司机一言不合又飙车
//        )
//
//    [field:houdunwang\model\Base:private] =>
//    [where:houdunwang\model\Base:private] => where aid = 1
//)
//        $data = Article::find(1)-> toArray();
//        dd($data);
        //Array
//        (
//        [aid] => 1
//    [atitle] => 老司机一言不合又飙车
//        )
//***************测试查询所有数据***************//
//        $data = Article::getAll();
//         dd($data);
        //dd(Student::find(1));
//        /Student::getAll());
//***************测试数据库根据where条件查找符合条件的数据***************//
//        $data = Student::where("age>30 and sex='女'")->getAll()->toArray();
//        dd($data);
//***************使用原生方式查询所有数据***************//
//      $data =Student::query('select * from student');
//      dd($data);
//***************测试获取指定字段***************//
//        $data = Student::field('name,sex,age')->getAll()->toArray();
//        dd($data);
//***************测试统计***************//
//        $data = Student::count();
//        $data = Student::where("age>30")->count();
//        dd($data);
//***************测试数据写入***************//
//         $data = [
//             'name' =>'新写入的',
//             'age' =>30,
//
//         ];
//         $data = Student::insert($data);
//         dd($data);
//***************测试数据更新***************//
//       dd(Student::update($data));
//        $data = [
//            'atitle' => '修改' ,
//        ];
//        $res  = Article::where("aid=2")->update ($data);
//        dd($res);
//        $data = Article::find(2)-> toArray();
//        dd($data);
//***************测试删除数据***************//
//       $res = Article::where("atitle = '修改'")->des();
//         dd($res);
       // return View::make();
//***************测数据***************//
//        $res = Student::field('id')->order('desc');
//        dd($res);
       return View::make();
    }

    public function add(){

    }

}


