<?php
//命名空间
//按照文件的路径起名
 namespace houdunwang\view;


 class Base {
//     声明数据库
//     用于存放数据
     protected $data = [];
//     声明变量
//     用于存放模板路径
     protected $file;
//      用于接受存储数据
     public  function with($var){
         //dd($var);
         $this->data = $var;
         return $this;
     }
//  显示路径的函数
     public function make(){
         //dd(MODULE);//home
         //dd(CONTROLLER);//entry
         //dd(ACTION);//index
         $this ->file = "../app/".MODULE."/view/".strtolower(CONTROLLER)."/".ACTION.".".c('view.suffix');
            return $this;
     }

//      用echo  输出一个对象的时候触发
     public function __toString()
     {
         // TODO: Implement __toString() method.
         //echo 1;
         //dd($this->data);
//         Array
//         (
//         )
         extract($this->data);
         include $this->file;
         return '';
     }
 }