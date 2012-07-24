<?php
require_once('db.class.php');

class User {
    public $id;
    public $name;
    public $pass; //hashed password
    function getName(){
        return $this->name;
    }

    function __construct() {


    }

    static function create($name, $pass, $check=true){
        if($check){
            $prev_user = User::findByName($name);
            if($prev_user){
                throw new Exception("Username already used");
            }
        }
        $ret = new User();
        $ret->name = $name;
        $ret->setPass($pass);
        return $ret;
    }

    static function find($user_id){
        $db = DbBase::open();
        $db->query(User::sql_lookup(), array($user_id));
        return first_or_null($db->create_objects('User'));
    }

    static function findByName($username){
        $db = DbBase::open();
        $sql = "SELECT * FROM `Users` WHERE name = ?";
        $db->query($sql, array($username));
        return first_or_null($db->create_objects('User'));
    }

    function getPosts(){
        return Post::findByUser($this->id);
    }

    function getListArticlesLink(){
        return "list-articles.php?mode=user&user_id=" . $this->id;
    }

    function apply(){
        if($this->id){
            $this->update();
        } else {
            $this->insert();
        }
    }

    function update(){
        $sql = User::sql_update();
        $db = DbBase::open();
        $cols = array("id", "name", "pass");
        $args = array();
        foreach($cols as $col){
            $args[$col] = $this->$col;    
        }
        $db->execute($sql, $args);
    }

    static function sql_upadate(){
        return "UPDATE `Users` SET `name` = :name, `pass` = :pass";
    }

    function setPass($pass){
        $this->pass = User::calc_hash($pass);
    }
    
    function insert(){
        $sql = User::sql_insert();
        $db = DbBase::open();
        $cols = array("id", "name", "pass");
        $args = array();
        foreach($cols as $col){
            $args[$col] = $this->$col;    
        }
        $db->execute($sql, $args);
    }

    static function sql_insert(){
        return "INSERT INTO `Users`(id,name,pass) VALUES (:id, :name, :pass)";
    }

    function is_authorized(){
        return !!$this->twitter_token;
    }

    static function sql_lookup(){
        return 'SELECT * From `Users` WHERE id = ?';
    }

    static function calc_hash($data){
        return substr(hash('whirlpool', $data . SALT), 0, 32);
    }

    static function auth($user, $pass){
        $user = User::findByName($user);
        if($user == null){
            throw new Exception("User not found");
        }
        $hash = User::calc_hash($pass);
        if($hash != $user->pass){
            throw new Exception("Invalid password");
        }
        return $user;
    }
}

?>

