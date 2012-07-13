<?php

function first_or_null($vals){
    if(count($vals) > 0){
        return $vals[0];
    } else {
        return null;
    }

}

/**
 * Provides common facilities and inteface of database access.
 */
class DbBase {

	function __construct() {

	}

	public static function open() {
		return DbBase::open_sqlite();
	}

	public static function open_sqlite() {
		return new SQLite("Database.db");
	}

	public static function open_mysql() {

	}

	public function query($sql, $ary=null) {
        $stmt = $this->prepare($sql, false); 
        if($ary != null)
            $stmt->execute($ary);
        else 
            $stmt->execute();
        return $stmt;
	}

    public function prepare($sql, $scroll=true){
        if($scroll)
            $stmt = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        else
            $stmt = $this->conn->prepare($sql);
        if(!$stmt) {
            throw new Exception("Cannot create query with '$sql'");
        }
        $this->current_stmt = $stmt;
        return $stmt;
    }

    public function create_objects($classname){
        $stmt = $this->current_stmt;
        $stmt->setFetchMode(PDO::FETCH_CLASS, $classname);
        $ret =  $stmt->fetchAll();
        return $ret;
    }

    public function update_object($obj){
        $stmt = $this->current_stmt;
        $stmt->setFetchMode(PDO::FETCH_INTO, $obj);
        return $stmt->fetch(PDO::FETCH_INTO);
    }

    public function fetch(){
        return $this->current_stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
    }

	public function execute($sql, $args=null) {
        $stmt = $this->prepare($sql, false);
        if($args != null)
            return $stmt->execute($args);
        else
            return $stmt->execute();
	}

    function lastInsertId(){
        return $this->conn->lastInsertId();
    }

}

/**
 * An implementation of DbBase using SQLite
 */
class SQLite extends DbBase {
	function __construct($filename, $reset_db=false) {
        $do_init = $reset_db || !file_exists($filename);
        $this -> conn = new PDO("sqlite:" . $filename, null, null, array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
		if ($do_init) {
            $this->init_db();
		}
	}

	function init_db() {
        $sql_path = realpath(__DIR__ . '/../sqls/init_sqlite.sql');
        $sql = file_get_contents($sql_path);
        $this->conn->exec($sql);
	}
}

/**
 * An implementation of DbBase using MySQL
 */
class MySQL extends DbBase {
	function __construct($host, $port, $user, $pass, $dbname) {
        $this -> conn = new PDO(sprintf("mysql:host=%s;port=%d;dbname=%s", $host, $port, $dbname), $user, $pass, array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
	}
}
?>