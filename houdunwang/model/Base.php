<?php
//命名空间
//按照文件的路径起名
namespace  houdunwang\model;
use PDO;
use PDOException;
use Exception;


class Base{
//    声明私有属性$pdo 默认值为null
//用于实例化类
    private static $pdo = null;
//    $table 为操作数据表名
    private  $table;
//    创建构造函数
    public function __construct($class)
    {
//        先连接数据库
//        检测数据是否为空
        if(is_null(self::$pdo)){
//            为空静态调用connect方法
           self::connect();
        }
//        获取我们需要的表名
        $info = strtolower(ltrim(strrchr($class,'\\'),'\\'));
        $this->table = $info;
    }
//       声明一个私有方法connect
    private  static function connect(){
        try{
//       定义dsn数据源：数据库类型,                 主机地址,                         数据库名
            $dsn = c('database.driver').":host=".c('database.host').";dbname=".c('database.dbname');
            $user = c('database.user');
            $password = c('database.password');
            //连接数据库
            self::$pdo = new PDO($dsn,$user,$password);
            //设置字符集     使用utf8编码
            self::$pdo->query('set names utf8');
            //设置错误属性   抛出异常
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $exception){
//                返回异常消息内容。
                 throw new Exception($exception->getMessage());
        }
    }
//    创建find方法  查找数据 获得数据表的id是什么
    public function find($id){
//     获取数据表的主键是谁
      $pk = $this->getPK();
//      拼接字符串,将查询到的语句赋值
      $sql = "select * from {$this->table} where {$pk}={$id}";
//    执行查询
      $data = $this->query($sql);
//      将数据返回出来
      return current($data);
    }
//    获取数据表的主键是id 还是cid
     private function  getPK(){
//        查看数据表的结构
         $sql = "desc " . $this->table;
//         执行查询
         $data = $this-> query($sql);
//         设置空字符串
         $pk ='';
//         执行foreach循环
         foreach ($data as $v){
//             查找主键
             if($v['Key']=='PRI'){
//                 把主键赋值给$pk
                 $pk = $v['Field'];
                 break;
             }
         }
//        将主键返回出来
           return $pk;
     }
//     执行有结果集的查询
     public function query($sql){
         try{
             //执行查询
             $res = self::$pdo->query($sql);
//            取出结果集
             return $row = $res-> fetchAll(\PDO::FETCH_ASSOC);

         }catch (PDOException $exception){
//            返回异常消息内容。
           throw new \Exception($exception->getMessage());
         }
     }
}