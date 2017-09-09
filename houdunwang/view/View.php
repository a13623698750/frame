<?php

namespace houdunwang\view;

class View{
//   当调用不存在的方法时候触发
//    $name不存在方法名称    $arguments	方法参数
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return self::parseAction ($name, $arguments);
    }
//   当静态调用不存在的方法时候触发
//    $name不存在方法名称    $arguments	方法参数
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        return self::parseAction($name,$arguments);
    }
//    调用其他类里面的方法 调用base类
//    $name不存在方法名称    $arguments	方法参数
    public  static  function  parseAction($name,$arguments){
        return call_user_func_array([new Base,$name],$arguments);
    }
}
