<?php
//命名空间
//按照文件的路径起名
namespace houdunwang\core;


class Boot{
    private static function handelr()
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();

    }
// 执行应用
//使用静态方法 不用实例化；直接用类名调用 效率高
    public static function run()
    {
        self::handelr();
//        检测是否可以正常输出
        //echo 1;
//        初始化框架
        self::init();
//        执行应用
        self::appRun();
    }
    /**
     * 初始化框架
     */
//使用静态方法 不用实例化；直接用类名调用 效率高
    public static function init()
    {
//          声明头部  设置页面内容是html  编码格式是utf8
//          如果不声明头部  浏览器上会出现乱码
        header('Content-type:text/html;charset=utf8');
//          设置时区
//          设置时区后，使用的时间是正确的  不设置时区，使用的时间有可能是错的
        date_default_timezone_set('PRC');
//          开启session
//          检测session_id 是否存在 存在就不需要开启session  不存在就开启session
        session_id() || session_start();
    }

    /**
     * 执行应用
     */
    public static function appRun()
    {
//          检测地址栏参数有否有s参数
        if (isset($_GET['s'])) {
//            如果有s参数  通过/将s参数打散为数组
            $info = explode('/', $_GET['s']);
//              控制类地址
            $class = "\app\\{$info[0]}\controller\\" . ucfirst($info[1]);
//            dd($class);die;
//             需要调用的类方法
            $action = $info['2'];
            //dd($class);
//              定义常量  方便全局调用
            define('MODULE', $info[0]);
            define('CONTROLLER', $info[1]);
            define('ACTION', $info[2]);
        } else {
//              如果没有s参数 给一个默认的地址栏参数
//              $class = "\app\home\controller\Entry"; 为默认的地址栏路径
            $class = "\app\home\controller\Entry";
//              $action = 'index'; 默认的调用方法 为index方法
            $action = 'index';
//              定义常量  方便全局调用
            define('MODULE', 'home');
            define('CONTROLLER', 'entry');
            define('ACTION', 'index');

        }
//          调用回调函数
        echo call_user_func_array([new $class, $action], []);
    }
}