<?php
//命名空间
//按照文件的路径起名
namespace houdunwang\model;
class Model{
//     当调用不存在的方法时候触发
//  $name	不存在方法名称  $arguments	方法参数
    public function __call($name, $arguments)
    {
        return self::parseAction($name,$arguments);

    }
//     当静态调用不存在的方法时候触发
//  $name	不存在方法名称  $arguments	方法参数
    public static function __callStatic($name, $arguments)
    {
        return self::parseAction($name,$arguments);
    }
//    调用其他类里面的方法 调用base类
//    $name不存在方法名称    $arguments	方法参数
    public static function parseAction($name,$argument){
      $class = get_called_class();
      return call_user_func_array([new Base($class),$name],$argument);
    }
}