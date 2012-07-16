<?php
require_once('db.class.php');

class User {
    public $id;
    public $name;
    function getName(){
        return $this->name;
    }

    function __construct() {


    }

    static function create($name){
        $ret = new User();
        $ret->name = $name;
        return $ret;
    }

    static function find($user_id){
        $db = DbBase::open();
        $db->query(User::sql_lookup(), array($user_id));
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
        $cols = array("id", "name");
        $args = array();
        foreach($cols as $col){
            $args[$col] = $this->$col;    
        }
        $db->execute($sql, $args);
    }

    static function sql_upadate(){
        return "UPDATE `Users` SET `name` = :name";
    }
    
    function insert(){
        $sql = User::sql_insert();
        $db = DbBase::open();
        $cols = array("id", "name");
        $args = array();
        foreach($cols as $col){
            $args[$col] = $this->$col;    
        }
        $db->execute($sql, $args);
    }

    static function sql_insert(){
        return "INSERT INTO `Users`(id,name) VALUES (:id, :name)";
    }

    function is_authorized(){
        return !!$this->twitter_token;
    }

    static function sql_lookup(){
        return 'SELECT * From `Users` WHERE id = ?';
    }

}

?>

