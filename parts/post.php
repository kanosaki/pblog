<div id="article">
	<h1><?php p($post->getTitle()); ?></h1>
    <dl class="dl-horizontal">
        <dt>Author</dt>
        <dd><a href="<?php p($post->getAuthor()->getListArticlesLink()); ?>"><?php p($post->getAuthor()->getName()); ?></a></dd>
        <dt>Tags</dt>
        <dd>
        <?php foreach($post->getTags() as $tag) { ?>
            <a href="<?php p($tag->getListArticlesLink()); ?>"><?php p($tag->getValue()); ?> </a>
        <?php } ?>
        </dd>
        <dt>Created</dt>
        <dd><?php p($post->getCreatedAtExpr()); ?></dd>
        <dt>Updated</dt>
        <dd><?php p($post->getUpdatedAtExpr()); ?></dd>
    </dl>
	<hr />
    <p><?php p($post->getBody()); ?></p>
	<hr />
	<a class="btn btn-info" href="<?php p($post->getEditLink())?>"><i class="icon-edit"></i> Edit</a>
	<a class="btn btn-danger" id="delete-button"><i class="icon-remove"></i> Delete</a>
</div>

<div class="modal hide fade" id="alert-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Delete Article '<?php p($post->getTitle()); ?>'</h3>
    </div>
    <div class="modal-body">
        <p>Warning!! This operation cannot be undone. Would you like to proceed?</p>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary">Cancel</button>
        <a id="exec-delete" class="btn btn-danger">OK</a>
    </div>
</div>

<div class="modal hide fade" id="delete-result-modal">
    <div class="modal-header">
        <h3>Info</h3>
    </div>
    <div class="modal-body">
        <p id="delete-result-message"></p>
    </div>
    <div class="modal-footer">
        <a class="btn btn-primary" id="result-modal-button">OK</a>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#delete-button").click(function(){
        $("#alert-modal").modal();
    });

    $("#exec-delete").click(function(){
        var param = { "post_id" : <?php echo $post->id; ?> };
        $.post("actions/delete-post.php", param, function(data, status){
            $("#alert-modal").modal('hide');
            $("#delete-result-message").text(data['message']);
            if(data["status"] == "OK"){
                $("#result-modal-button").attr('href', 'index.php');
                $("#delete-result-modal").modal({'backdrop' : 'static', 'keyboard' : false});
            } else {
                $("#result-modal-button").attr('href', '#');
                $("#delete-result-modal").modal();
            }
        }, "json");
    });
});
</script>
