<!doctype html>
<html>
    <head>
        <?php require 'common-head.php'; ?>
    </head>
    <body>
        <?php require 'navbar.php'; ?>
        <div id="top-padding" style="height: 50px;"></div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2"
                ></div>
                <div class="span10">
                    <h2>Login</h2>
                    <div class="login-buttons">
                        <div class="with-twitter">
                            <h3>Login with twitter</h3>
                            <a id="twitter-sign-in" class="hide" href=""><img src="img/sign-in-twitter.png" alt="Sign in with Twitter" /></a>
                            <p id="twitter-msg">Requesting Twitter for your login. Please wait.</p>
                        </div> 
                        <div class="with-openid">
                            <h3>Login with OpenID(Google, mixi, etc..)</h3>
                            <p>Sorry, Not impelemented. </p>
                        </div>
                   </div>
                </div>
            </div><!--/row-->

            <hr>

            <?php require 'footer.php' ?>

        </div><!--/.fluid-container-->
<script type="text/javascript">
(function(){
var load_twtter = function(){
    $.get("actions/login-twitter.php", function(data){
        if(data['status'] == 'OK'){
            $("#twitter-sign-in").attr("href", data['request_url']);
            $("#twitter-sign-in").show();
        }
        $("#twitter-msg").text(data['message']);
    });
};
$(document).ready(function(){
    //load_twtter();
});
})();
</script>
    </body>
</html>
