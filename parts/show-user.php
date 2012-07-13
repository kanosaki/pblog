<h1>User profile</h1>
<div id="user-profile">
    <div class="basics">
        <div class="page-header">
            <h2>Basics</h2>
        </div>
        <p id="user-name"></p>
    </div>
    <div id="linked-twitter">

    </div> 
</div>
<div id="edit-profile">
    <form id="edit-form" class="form-horizontal">
        <fieldset>
            <div class="control-group">
                <label for="name-input" class="control-label">Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="name-input" />
                </div>
            </div>
            <div class="control-group">
                <label for="name-input" class="control-label">Unlink account</label>
                <div class="controls">
                    <a href="#" class="btn btn-info">Unlink Twitter</a>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="edit-complete-button">OK</button>
            </div>
        </fieldset> 
    </form>
</div>
<script type="text/javascript">
(function(){
<?php 
$user_id = $user->id;
$user_name = $user->name;
echo "var user_id = '$user_id';";
echo "var user_name = '$user_name';";
?>
var enter_editmode = function(){
    $("#edit-profile").show();
    $("#user-profile").hide();
};

var restore_showmode = function(data){
    $("#user-name").text(data['name']);
    $("#edit-profile").hide();
    $("#user-profile").show();
};

var post_profile_update = function(){
    user_name = $("#name-input").val();
    $.post("actions/update-user.php", 
        {
            "name" : user_name 
        },
        function(data, status){
            if(data['status'] == 'OK'){
            
            } else {

            }
        });
};
$(document).ready(function(){
    $("#edit-profile").hide();
    if(user_name == ""){
        enter_editmode();
    }
    $("#edit-complete-button").click(post_profile_update);
    $('#edit-form').submit(function(){
        return false; // Disable page reloading.
    });
});
})();
</script>
