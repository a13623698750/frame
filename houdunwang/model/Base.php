<?php
//命名空间
//按照文件的路径起名
namespace  houdunwang\model;
use PDO;
use PDOException;
use Exception;


class Base{
//    声明静态属性$pdo 默认值为null  可以全局调用
//    用于实例化类
    private static $pdo = null;
//    $table 声明操作数据表名
    private  $table;
//    $data存放查询结构的数据
     private $data;
//     获取指定字段
    private $field = '';
//      where条件
//     需要通过什么条件获得符合条件的数据
    private $where = '';
//    创建构造函数
    public function __construct($class)
    {
//        先连接数据库
//        检测数据是否为空        
        if(is_null(self::$pdo)){
//            为空静态调用connect方法            
             $this->connect();
        }
       $into = explode('\\',$class);
        $this->table = strtolower($into[2]);
    }
    private function connect(){
//      try {} catch (){} 可以让程序出现异常导致程序崩溃的时候让程序正常的运行下去
        try{
//           dsn数据源：数据库类型,主机地址,数据库名
            $dsn = "mysql:host=127.0.0.1;dbname=c86";
//            用户名
            $user = "root";
//            密码
            $password="root";
//                连接数据库
            self::$pdo = new PDO($dsn,$user,$password);
//          设置字符集  使用utf8编码
            self::$pdo->query('set names utf8');
//           设置错误属性  抛出异常
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        }catch (PDOException $exception){
//            返回异常消息内容。
            throw new Exception($exception->getMessage());
        }
    }
//  获得需要的指定内容字段 如学生表的age name sex   文章表的title
    public function field($field){
        $this->field = $field;
        return $this;
    }

//     统计数据
    public function count(){
        
        $sql = "select count(*) as total from {$this->table} {$this->where}";
        $data = $this->query($sql);
        return$data[0]['total'];
    }


//    排序
    public function order($var = ""){

        if(empty($this->field)){
            return false;
        }
        $sql = "select * from {$this->table} order by {$this->field} {$var} ";
        return $this->query($sql);
    }


//       执行数据写入
//        $data    要写入的数据
    public function insert($data){
//        存储名
        $fields = '';
//        存储值
        $values = '';
        foreach ($data as $k =>$v){

            if(is_int($v)){
                $fields .=$k .',';
                $values .=$v . ",";
            }else{
                $fields .=$k .',';
                $values .= "'$v'" . ',';
            }
        }
//       删除最后面的,
        $fields = rtrim ( $fields , ',' );
        $values = rtrim ( $values , ',' );
        dd($fields);
        $sql = "insert into {$this->table} ($fields) values ($values)";
//        dd($sql);
        //执行sql语句
        return $this-> exec($sql);
    }
   
//    删除数据
//     $pk 删除主键值
    public function  des($pk = ''){
        if ( empty( $this->where ) || empty( $pk ) ) {
//            检测是否有where条件 没有where条件 执行下面函数
            if ( empty( $this->where ) ) {
//             获取主键
                $priKey = $this->getPriKey ();
//                因为没有where条件语句  把des传入参数作为where条件
                $this->where ( "{$priKey}={$pk}" );
            }
            $sql = "delete from {$this->table} {$this->where}";

            //执行sql语句
            return $this->exec ( $sql );
        } else {
            return false;
        }
    }


//   数据更新方法
//   执行更新数据
//  array $data 更新的数据
    public function update(array $data){
//        检测是否有where条件语句 没有则不能更新数据
        if (empty($this->where))
       return false;
        //dd($data);die;//bool(false)
//     声明空字符串，用来存储重组完成的结果
        $fields = '';
       foreach ( $data as $k => $v ){
           if ( is_int ( $v ) ) {
               $fields .= "$k=$v" . ',';
           } else {
               $fields .= "$k='$v'" . ',';
           }
       }
//       删除最后面的,
        $fields = rtrim ( $fields , ',' );
        //dd($fields);//bool(false)
        $sql = "update {$this->table} set {$fields} {$this->where}";

        //执行sql语句
        return $this->exec ( $sql );
    }

//    获取数据库中所有数据
    public function  getAll(){
        $field = $this->field?:'*';
//       组合查询所有数据的sql语句
        $sql = "select {$field} from {$this->table} {$this->where}";
//       调用自定义的query查询
        $data = $this->query ( $sql );
        if (!empty($data)){
            $this ->data = $data;
            return $this;
        }
        return [];
    }

//  创建find方法  查找数据 获得数据表的id是什么
//    $pk    主键值
    public function find($pk){
//      检测find方法是否可用
//      echo 111
//      获取当前操作表的主键
       $priKey = $this->getPK();
       //dd($priKey);//aid
//        $sql = "select * from 表名 where 主键=$pk";
//        通过where方法  查找符合条件的数据
//        把sql中where条件语句存储到where属性中
        $this->where("$priKey = {$pk}");
//     field   获取指定字段  看需求查找数据表的所有内容 还是需要age name 等等
        $field = $this -> field? : "*";
//        组合sql语句
        $sql = "select {$field} from {$this->table} {$this->where}";
        $data = $this->query($sql);
//        检测数据是否为空
        if(!empty($data)){
//            不为空函数返回数组中的数据
            $this -> data = current($data);
            return  $this;
        }
        return  $this;

        return [];
    }


//    将对象转为数组
//    array    转换之后的数组
    public function toArray(){
        if ($this->data) {
            return $this->data;
        }
    }
//   sql查询语句中where条件
    public function where($where){
        $this -> where = "where {$where}";
        return $this;
    }

//    获取主键
    public function getPK()
    {
//        查看数据表的结构
//        查找主键
        $sql = "desc " . $this->table;
//        调用query方法进行查询
        $data = $this->query($sql);
        //dd($data);
//      定义空字符串用来存储主键
        $priKey = '';
        foreach ($data as $v) {
            if ($v['Key'] == 'PRI') {
                //说明是主键
                $priKey = $v['Field'];
                break;
            }
        }
        return  $priKey;
    }
    /**
     * @param $sql    查询的sql语句
     * @return mixed
     * @throws Exception
     */
   public function query($sql){
        try{
//            执行查询
            $res = self::$pdo->query($sql);
//            取出结果集
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
//            返回异常消息内容。
            throw new Exception($exception->getMessage());
        }
   }
//   执行没有结果集的sql
   public function exec($sql){
       try{
//           执行查询
           $res = self::$pdo->exec($sql);
//
           if ($lastInsertId = self::$pdo->lastInsertId()){
               return $lastInsertId;
           }
           return $res;
       }catch (PDOException $exception){
//            返回异常消息内容。
           throw new Exception( $exception->getMessage () );
       }
   }

}