<?php
require_once 'lib/common.php';
$page_title = "Posts";
$page_body = "postlist.php";

require_once 'models/post.class.php';
require_once 'models/user.class.php';
require_once 'models/tag.class.php';

if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
    if($mode == "recent"){
        $count = isset($_GET['count']) ? ((int)$_GET['count']) : 10;
        $posts = Post::recent_posts($count);
        $list_mode = "Recent articles. (Max $count)";
    } else if($mode == "all"){
        $posts = Post::all_posts();
        $list_mode = "All articles.";
    } else if($mode == "tag"){
        if(!isset($_GET['tag_id'])){
            echo "Missing tag_id!!";
            exit;
        }
        $tag = Tag::find($_GET['tag_id']);
        if(!$tag){
            echo "Tag not found!";
            exit;
        }
        $posts = $tag->getPosts();
        $tagname = $tag->value;
        $list_mode = "Articles tagged $tagname";
    } else if($mode == "user"){
        if(!isset($_GET['user_id'])){
            echo "Missing user_id!!";
            exit;
        }
        $user_id = $_GET['user_id'];
        $user = User::find($user_id);
        if(!$user){
            echo "User not found!";
            exit;
        }
        $posts = $user->getPosts();
        $username = $user->name;
        $list_mode = "Articles by $username";
    }
} else{
    $posts = Post::all_posts();
}

require_once "parts/default.php";
?>
