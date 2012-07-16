<div id="article">
	<h1><?php p($post->getTitle()); ?></h1>
    <dl class="dl-horizontal">
        <dt>Author</dt>
        <dd><?php p($post->getAuthor()->getName()); ?></dd>
        <dt>Tags</dt>
        <dd><?php p($post->getTagsExpr()); ?></dd>
        <dt>Created</dt>
        <dd><?php p($post->getCreatedAtExpr()); ?></dd>
        <dt>Updated</dt>
        <dd><?php p($post->getUpdatedAtExpr()); ?></dd>
    </dl>
	<hr />
    <p><?php p($post->getBody()); ?></p>
	<hr />
	<a class="btn btn-info" href="<?php p($post->getEditLink())?>"><i class="icon-edit"></i> Edit</a>
</div>

<div class="modal hide" id="alert-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Modal header</h3>
    </div>
    <div class="modal-body">
        <p>Invalid request. No article id has been given</p>
    </div>
    <div class="modal-footer">
        <a href="<?php echo $backurl; ?>" class="btn btn-primary">OK</a>
    </div>
</div>

<?php if(!$post) { ?>
<script type="text/javascript">
$(document).ready(function(){
    $("#alert-modal").modal();
});
</script>
<?php } ?>
