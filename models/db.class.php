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
    private static $instance = null;

	function __construct() {

	}

	public static function open() {
        if(self::$instance == null){
            if(USE_SQLITE){
                self::$instance = DbBase::open_sqlite();
            } else {
                self::$instance = DbBase::open_mysql();
            }
        }
        return self::$instance;
	}

	public static function open_sqlite() {
		return new SQLite("Database.db");
	}

	public static function open_mysql() {
        return new MySQL(
            MYSQL_HOST,
            MYSQL_PORT,
            MYSQL_DBUSER,
            trim(file_get_contents(MYSQL_DBPASS_FILE)),
            MYSQL_DB);
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
        $this->commit();
	}

    function commit(){
        $this->conn->commit();
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
        $path = SQLite::db_path($filename);
        $do_init = $reset_db || !file_exists($path);
        $this -> conn = new PDO("sqlite://" . $path, null, null, array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
		if ($do_init) {
            $this->init_db();
		}
        // Enable foreign key restriction.
        $this->conn->exec("PRAGMA foreign_keys = ON");
	}

    static function db_path($filename){
        return realpath(__DIR__) . '/../' . $filename;
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
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
	}
}
?>
