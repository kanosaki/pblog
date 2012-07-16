<footer>
    <p>
        &copy; kanosaki
    </p>
</footer>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-alert.js"></script>
<?php if(false) { ?>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<?php } ?>
<script type="text/javascript">
// Auto active 
$(document).ready(function(){
    $(".active-<?php echo getCurrentPageID(); ?>").addClass("active");
<?php if(!defined('CONFIG_LOADED')){ ?>
    $("#alert-area").text("ERROR: Config was not found!!");
<?php } ?>
});

</script>
