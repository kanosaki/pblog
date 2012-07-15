<h1>Articles <small><?php p($list_mode); ?></small></h1>

<?php foreach($posts as $post) { ?>
<div class="post-wrap">
    <div class="page-header post-title">
	<h2><a href="<?php p($post->getLink()); ?>"><?php p($post->getTitle()); ?></a> <a href="<?php echo $post->getEditLink(); ?>"><small>Edit</small></a></h2>
    </div>
    <div class="post-body">
    <?php p($post->getBody()); ?> 
    </div>
</div>

<?php } ?> 
