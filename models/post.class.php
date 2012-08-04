<?php
require_once 'db.class.php';
require_once 'tag.class.php';
require_once 'user.class.php';
require_once 'lib/markdown.php';

$markdown_converter = new Markdown_Parser;
$markdown_converter->no_markup = true;
$markdown_converter->no_entities = true;

function convert_markdown($text){
    global $markdown_converter;
    return $markdown_converter->transform($text); 
}

/**
 *
 */
class Post {
    static $column_map = array(
        'id' => 'id',
        'title' => 'title',
        'body' => 'body',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
        'author_id' => 'author_id',
    );
    private $rendered_html = "";

    public $body = "";
    function getBody(){
        if(!$this->rendered_html){
            $this->rendered_html = convert_markdown($this->body);
        }
        return $this->rendered_html;
    }
    function getRawBody(){
        return $this->body;
    }
    public $title = "";
    function getTitle(){
        return $this->title;
    }
    public $created_at = "";
    public $updated_at = "";
    public $tags = null;
    public $author_id = null;
    function getAuthor(){
        if($this->author == null){
            $this->author = User::find($this->author_id);
        }
        return $this->author;
    }
    public $id = null;

    public $author = null;

    function __construct() {
    }

    public static function create($author_id, $title, $body)
    {
        $ret = new Post();
        $now = time();
        $ret->author_id = $author_id;
        $ret->body = $body;
        $ret->title = $title;
        $ret->created_at = $now;
        $ret->updated_at = $now;
        $ret->insert();
        return $ret;
    }

    function delete(){
        $db = DbBase::open();
        $sql = "DELETE FROM `Posts` WHERE `id` = ?";
        $db->execute($sql, array($this->id));
    }

    function getEditLink(){
        return "edit.php?post_id=" . $this->id;
    }

    function getLink(){
        return "show-article.php?post_id=" . $this->id;
    }

    function getCreatedAtExpr(){
        return Post::getTimeStampExpr($this->created_at);
    }

    function getUpdatedAtExpr(){
        return Post::getTimeStampExpr($this->updated_at);
    }

    static function getTimeStampExpr($time){
        return date("Y/m/d H:i:s", (int)$time);

    }


    public static function find($post_id){
        $db = DbBase::open();
        $db->query('SELECT * From Posts WHERE id = ?', array($post_id));
        return first_or_null($db->create_objects('Post'));
    }
    
    static function findByUser($user_id){
        $db = DbBase::open();
        $db->query('SELECT * FROM `Posts` WHERE author_id = ?', array($user_id));
        return $db->create_objects('Post');
    }

    static function findByTagValue($tag_expr){
        $tag = Tag::findByValue($tag_expr);
        if(!$tag) return null;
        return Post::findByTagID($tag->id);
    }

    static function findByTagID($tag_id){
        $db = DbBase::open();
        $sql = 'SELECT * FROM `Posts` WHERE id IN (SELECT post_id FROM Post_Tag WHERE tag_id = ?)';
        $query = $db->query($sql, array($tag_id));
        return $db->create_objects('Post');
    }

    static function all_posts(){
        $db = DbBase::open();
        $db->query('SELECT * From `Posts` ORDER BY id DESC');
        return $db->create_objects('Post');
    }

    public static function recent_posts($count){
        $db = DbBase::open();
        $db->query('SELECT * FROM `Posts` ORDER BY id DESC LIMIT ?', array($count));
        return $db->create_objects('Post');
    }

    static function getListArticleLink($mode, $params){
        return "list-article.php?mode=$mode&$params";
    }

    function getTags(){
        if(!$this->tags){
            $this->tags = Tag::findByPost($this->id);
        }
        return $this->tags;
    }

    function getTagsExpr(){
        $tags = array_map(array('Tag', 'mapValue'), $this->getTags());
        return join(", ", $tags);
    }

    function setTags($tags_expr){
        $newTags = Tag::parse($tags_expr);
        $oldTags = array_map(array('Tag', 'mapValue'), $this->getTags());
        $created = array_diff($newTags, $oldTags);
        $deleted = array_diff($oldTags, $newTags);
        $db = DbBase::open();

        if(count($deleted) > 0){
            $sql_delete = 'DELETE FROM `Post_Tag` WHERE `tag_id` = (SELECT `id` FROM `Tags` WHERE `value` = ?)';
            $stmt = $db->prepare($sql_delete, false);
            foreach($deleted as $dtag){
                $stmt->execute(array($dtag));
            }
        }
        
        if(count($created) > 0){
            Tag::update($created);
            $sql_create = 'INSERT INTO `Post_Tag`(id, post_id, tag_id) VALUES (:id, :post_id, :tag_id)';
            $stmt = $db->prepare($sql_create, false);
            $tag_stmt = $db->prepare('SELECT `id` FROM `Tags` WHERE `value` = ?', false);
            foreach($created as $ctag){
                $tag_stmt->execute(array($ctag));
                $resall = $tag_stmt->fetchAll();
                $res = $resall[0];
                $args = array(
                    "id"        => null,
                    "post_id"   => $this->id,
                    "tag_id" => $res['id']
                );
                $stmt->execute($args);
            }
        }
        $this->tags = $newTags;
    }

    function sql_insert(){
        return 'INSERT INTO `Posts`(id, title, body, created_at, updated_at, author_id) Values (:id, :title, :body, :created_at, :updated_at, :author_id)';
    }

    function touch(){
        $now = new DateTime();
        $this->updated_at = $now->getTimeStamp();
    }

    function apply(){
        if($this->id){
            $this->update();
        } else {
            $this->insert(); 
        }
    }

    function insert(){
        $db = DbBase::open();
        $args = array();
        foreach(self::$column_map as $key => $val){
            $args[$key] = $this->$val;
        }
        $db->execute($this->sql_insert(), $args);
        $this->id = $db->lastInsertId();
    }

    function update(){
        $db = DbBase::open();
        $args = array();
        $cols = array("title", "body", "updated_at", "id");
        foreach($cols as $key){
            $args[$key] = $this->$key;
        }
        $db->execute($this->sql_update(), $args);
    }

    function lookup_tags(){
        $query = $this->db->query($this->sql_tags_lookup(), array($this->id));
        return $query->fetchAll();
    }

    function sql_lookup(){
        return 'SELECT * From Posts WHERE id = :id';
    }

    function sql_tags_lookup(){
        return 'SELECT value FROM Tags WHERE id = (SELECT tag_id from post_tag where post_id = ?)';
    }

    function sql_update(){
        return 'UPDATE `Posts` SET `title` = :title, `body` = :body, `updated_at` = :updated_at WHERE `id` = :id';
    }
}
?>
