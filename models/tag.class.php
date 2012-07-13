<?php
require_once 'db.class.php';

class Tag {
    public $value = "";
    public $id = null;
    
    public static function findByPost($post_id){
        $db = DbBase::open();
        $sql = 'SELECT value FROM TAGS WHERE id IN (SELECT tag_id from post_tag where post_id = ?)';
        $query = $db->query($sql, array($post_id));
        return $db->create_objects('Tag');
    }

    static function findByValue($value){
        $db = DbBase::open();
        $sql = 'SELECT * FROM TAGS WHERE `value` = ?';
        $db->query($sql, array($value));
        return first_or_null($db->create_objects('Tag'));
    }

    static function parse($expr){
        return preg_split("/[\s,]+/", $expr, null, PREG_SPLIT_NO_EMPTY);
    }
    
    static function update($tags){
        $db = DbBase::open();
        $sql_select = "SELECT `id` FROM `Tags` WHERE `value` = ?";
        $select = $db->prepare($sql_select, false);
        $sql_insert = 'INSERT INTO `Tags`(`id`, `value`) VALUES (?, ?)';
        $insert = $db->prepare($sql_insert, false);
        foreach($tags as $tag){
            $select->execute(array($tag));
            if(!$select->fetch()){
                $insert->execute(array(null, $tag));
            }
        }
    }

    static function mapValue($tag){
        return $tag->value;
    }
}

?>