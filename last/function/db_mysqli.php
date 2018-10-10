<?php
//header
header('content-type:text/html;charset=UTF-8');
# from https://www.cnblogs.com/hmzc/p/5447707.html
require_once("config.php");
class DB {
    //定义属性
    private $host;//主机名
    private $port;//端口号
    private $name;//用户名
    private $pass;//密码
    private $dbname;//数据库名
    private $charset;//设置字符集
    private $link;//连接数据库
    private static $instance;
    //初始化  构造函数
    public function __construct($arr = array()){
        $this->host = isset($arr['host']) ? $arr['host'] : 'localhost' ;
        $this->port = isset($arr['port']) ? $arr['port'] : '3306' ;
        $this->name = isset($arr['name']) ? $arr['name'] : 'game2018' ;
        $this->pass = isset($arr['pass']) ? $arr['pass'] : 'tyl@2018' ;
        $this->dbname = isset($arr['dbname']) ? $arr['dbname'] : 'game2018' ;
        $this->charset = isset($arr['charset']) ? $arr['charset'] : 'utf8' ;
        //连接数据库
        $this->db_connect();
        //选择数据库
        $this->db_usedb();
        //设置字符集
        $this->db_charset();
    }
    //连接数据库
    private function db_connect(){
        //主机名:端口号   用户名  密码
        $this->link = mysqli_connect($this->host, $this->name, $this->pass);
        //连接失败
        if(!$this->link){
            echo '数据库连接失败<br>';
            echo '错误编码是:'.mysqli_errno($this->link).'<br>';
            echo '错误信息是:'.mysqli_error($this->link).'<br>';
            exit;
        }
    }
    //选择数据库
    private function db_usedb(){
        mysqli_query($this->link, "use {$this->dbname}");
    }
    //设置字符集
    private function db_charset(){
        mysqli_query($this->link, "set names {$this->charset}");
    }
    //私有化克隆函数，防止外界克隆对象
    private function __clone()
    {
    }
 
    //单例访问统一入口
    public static function getInstance($arr)
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance = new self($arr);
        }
        return self::$instance;
    }    
    /**
     * 执行语句
     * @param  $sql
     * @return source
     */
    private function query($sql){
        $res = mysqli_query($this->link, $sql);
        if(!$res){
            echo 'sql语句有错误<br>';
            echo '错误编码是:'.mysqli_errno($this->link).'<br>';
            echo '错误信息是:'.mysqli_error($this->link).'<br>';
            echo $sql;
            exit;
        }
        return $res;//成功返回数据
    }
    /**
     * 获取刚插入数据的id
     * @return int
     */
    public function getInsertId(){
        return mysqli_insert_id($this->link);
    }
    /**
     * 查询某个字段, 例如 select count(*),  select username
     * @param  $sql
     * @return string or int
     */
    public function getOne($sql){
        $query = $this->query($sql);
        return mysqli_free_result($query);
    }
    /**
     * 获取一行记录
     * @param  $sql
     * @return array 一维
     */
    public function getRow($sql, $type='assoc'){
        $query = $this->query($sql);
        if(!in_array($type, array("assoc", "array", "row"))){
            die("mysql_query error");
        }
        $functionname = "mysqli_fetch_".$type;
        return $functionname($query);
    }
    /**
     * 前置条件:通过资源获取一条记录
     * @param  $query source
     * @return array 一维
     */
    public function getRowFromSource($query, $type="assoc"){
        if(!in_array($type, array("assoc", "array", "row"))){
            die("mysql_query error");
        }
        $functionname = "mysqli_fetch_".$type;
        return $functionname($query);
    }
    /**
     * 获取所有记录
     * @param  $sql
     * @return array 二维
     */
    public function getAll($sql){
        $query = $this->query($sql);
        $list = array();
        while ($row = $this->getRowFromSource($query)) {
            $list[] = $row;
        }
        return $list;
    }
    /*
    * 新增数据方法
    * @param1 $table, $data 表名 数据
    * @return 上一次增加操做产生ID值
    */
    public function insert($table, $data){
        //遍历数组，得到每一个字段和字段的值
        $kstr = '' ;
        $vstr = '' ;
        foreach ($data as $key => $val) {
            //$key是字段名, $val是对应的值
            $kstr .= $key."," ;
            $vstr .= "'$val',";
        }
        $kstr = rtrim($kstr, ',');
        $vstr = rtrim($vstr, ',');
        //添加的sql语句
        $sql = "insert into $table ($kstr) values ($vstr)";
        
        //执行
        $this->query($sql);
        //返回上一次增加操做产生ID值
        return $this->getInsertId();
    }
    /*
    * 删除一条数据方法
    * @param1 $table, $where=array('id'=>'1') 表名 条件
    * @return 受影响的行数
    */
    public function deleteOne($table, $where){
        if(is_array($where)){
            foreach ($where as $key => $val) {
                $condition = $key.'='.$val;
            }
        } else {
            $condition = $where;
        }
        $sql = "delete from $table where $condition";
        $this->query($sql);
        //返回受影响的行数
        return mysqli_affected_rows($this->link);
    }
    /*
    * 删除多条数据方法
    * @param1 $table, $where 表名 条件
    * @return 受影响的行数
    */
    public function deleteAll($table, $where){
        if(is_array($where)){
            foreach ($where as $key => $val) {
                if(is_array($val)){
                    $condition = $key.' in ('.implode(',', $val) .')';
                } else {
                    $condition = $key. '=' .$val;
                }
            }
        } else {
            $condition = $where;
        }
        $sql = "delete from $table where $condition";
        $this->query($sql);
        //返回受影响的行数
        return mysqli_affected_rows($this->link);
    }
    /*
    * 修改数据方法
    * @param1 $table,$data,$where 表名 数据 条件
    * @return 受影响的行数
    */
    public function update($table,$data,$where){
        //遍历数组，得到每一个字段和字段的值
        $str='';
        if(is_array($data)){
            foreach($data as $key=>$v){
                $str.="$key='$v',";  
            }
            $str=rtrim($str,',');
            //修改的SQL语句
            $sql="update $table set $str where $where";
        } else {
            //修改的SQL语句
            $sql="update $table set $data where $where";
        }
        $this->query($sql);
        //返回受影响的行数
        return mysqli_affected_rows($this->link);
    }
}