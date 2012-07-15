<div id="article">
    <h2><?php p($post->getTitle()); ?></h2>
    <p><?php p($post->getBody()); ?></p>
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
