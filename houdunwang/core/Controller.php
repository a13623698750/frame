<?php
//命名空间
//按照文件的路径起名
namespace houdunwang\core;

class Controller{
//    定义默认跳转地址   返回当前
    private  $url = "window.history.back()";
//     提示消息
//       $message为提示的消息内容
    public function message($message){
//        加载public/view/message.php文件
//        这个文件是消息提示得到模板文件
       include "./view/message.php";
       exit;
    }
//    跳转
//         $url 跳转地址
    public function setRedirect($url = ''){
//        检测跳转地址是否为空
     if (empty($url)){
//         为空则让跳转地址为window.history.back() 返回上一级
         $this->url = "window.history.back()";
     }else{
//         地址不为空 则跳转到检测出的地址
         $this->url = "location.href = '$url'";
     }
     return $this;
    }

}