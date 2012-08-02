<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
            <a class="brand" href="#">P-Blog</a>
            <div id="login-user" class="btn-group pull-right">
            <a  class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> <span id="login-username"></span> <span class="caret"></span> </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a id="signout-link">Sign Out</a>
                    </li>
                </ul>
            </div>
            <div id="login-guest" class="pull-right">
                <a id="login-button" class="btn">Login</a>
            </div>            
            <div class="nav-collapse">
                <ul class="nav">
                    <li class="active-index">
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="edit.php">Create article</a>
                    </li>
                    <li>
                        <a href="#contact">Contact</a>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<div id="login-form-wrap"></div>
<script type="text/javascript">
$(function(){
    var username = <?php echo ($session->is_logined()) ? '"' . ($session->user_name()) . '"' : "null" ?>;
    window.userinfo_updated = new pblog.Event();
    window.userinfo_updated.bind(function(name){
        if(name != null){
            $("#login-user").show();
            $("#login-guest").hide();
            $("#login-username").text(name);
        }else{
            $("#login-user").hide();
            $("#login-guest").show();
        }
    });
    
    $("#login-button").click(function(){
        $.get("forms/login-modal.php", function(data, status){
            $("#login-form-wrap").append(data);
            $("#login-form-wrap > div").modal();
        });
    });    

    $("#signout-link").click(function(){
        $.post("actions/sign-out.php", function(data, status){
            if(data.status === "OK"){
                alert("Successfully logged out");
            }
            location = "index.php";
        });
    });
    window.userinfo_updated.trigger(username);
});
</script>
