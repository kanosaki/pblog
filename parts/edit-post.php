<?php 

// TODO: Add form validation.

// REST style
// GET  ->  has(post_id) -> Edit
//      -> !has(post_id) -> Create
// POST -> Update/Create 

require 'models/post.class.php';
if(isset($_GET['post_id'])){
    // Edit article
    $post = new Post($_GET['post_id']);
    $editing = true;
    $first_header = "Edit article '$post->title'";
} else {
    $post = new Post();
    $editing = false;
    $first_header = "Create article";
}
?>

<h2 class="title-text"><?php p($first_header); ?></h2>
<div class="edit-form">
    <form action="actions/post.php" method="POST" class="form-horizontal">
        <div id="title-block" class="control-group">
            <label for="title-text" class="control-label">Title</label>
            <div class="controls">
                <input type="text" name="post-text" id="title-text" style="width: 100%;" placeholder="Enter title..." value="<?php p($post->getTitle()); ?>">
            </div>
        </div>
        <hr />
        <div id="body-block" class="control-group">
            <label for"body-text" class="control-label">Body</label>
            <div class="controls">
                <textarea id="body-text" name="post-body" rows="20" style="width: 100%;" placeholder="Body"><?php p($post->getBody()) ?></textarea>
            </div>
        </div>
        <div id="body-block" class="control-group">
            <label for"tags-text" class="control-label">Tags</label>
            <div class="controls">
                <input type="text" name="post-tags" id="tags-text" style="width: 100%;" placeholder="Enter tags...(Splitting by Comma)" value="">
            </div>
        </div>
        <div id="submit-area" class="form-actions">
            <button id="apply-button" class="btn btn-primary">Upload</button>
            <button class="btn btn-small">Cancel</button>
        </div>
    </form>
</div>
<div id="alerts" class="hide">
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">DONE!</h4>
        <p id="success-msg"></p>
    </div>
    <div class="alert alert-error">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Warning!</h4>
        <p id="error-msg"></p>
    </div>
</div>

<script type="text/javascript">
$(function(){
    $("#apply-button").click(function(){
        var data = {
            "title" : $("#title-text").val(),
            "body"  : $("#body-text").text(),
            "tags"  : $("#tags-text").text()

        };
        $.post("action/update-post.php", data,
            function(data, status){
                if(data['status'] == "OK"){
                    $("#success-msg").html(data['msg']);
                    $("#submit-area").append($("#success-msg").clone());
                } else  {
                    $("#error-msg").text(data['msg']);
                    $("#submit-area").append($("#error-msg").clone());
                }
            }, "json");
    });  
});
</script>
