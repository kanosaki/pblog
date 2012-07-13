<?php
require_once 'user.class.php';
require_once 'post.class.php';

$recent = Post::recent_posts(10);
if(count($recent) > 0){
    $p = $recent[0];
} else {
    $p = Post::create(1, "Title", "Body");
}

$p->setTags("hoge, fuga, ");

var_dump($p->getTags());
?>
