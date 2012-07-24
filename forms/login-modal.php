<div class="modal fade" id="wrap-modal">
    <div class="modal-header">
        <h3>Login</h3>
    </div>
    <div class="modal-footer">
        <a class="btn btn-primary" id="login-button">Log in</a>
        <a class="btn" id="signup-button">Sign up</a>
    </div>
    <div class="modal hide fade" id="input-modal">
        <div class="modal-header">
            <h3 id="input-title">Login</h3>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <div id="username-block" class="control-group">
                    <label for="title-text" class="control-label">Username</label>
                    <div class="controls">
                        <input  type="text" id="username-text"
                                style="width: 100%;" 
                                value="">
                        <span id="username-help" class="help-inline"></span>
                    </div>
                </div>
                <div id="password-block" class="control-group">
                    <label for="body-text" class="control-label">Password</label>
                    <div class="controls">
                        <input  type="password" id="password-text"
                                style="width: 100%;" 
                                value="">
                        <span id="password-help" class="help-inline"></span>
                    </div>
                </div>
                <div id="confirm-block" class="control-group hide">
                    <label for="body-text" class="control-label">Re-type Password</label>
                    <div class="controls">
                        <input  type="password" id="confirm-text"
                                style="width: 100%;" 
                                value="">
                        <span id="confirm-help" class="help-inline"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" id="input-ok-button">OK</a>
            <a class="btn" id="input-cancel-button">Cancel</a>
        </div>

    </div>
    <div class="modal hide fade" id="result-modal">
        <div class="modal-header">
            <h3 id="result-title"></h3>
        </div>
        <div class="modal-body">
            <div id="result-message"></div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" id="result-ok-button">OK</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/bootstrap-modal.js"></script>
<script type="text/javascript">
$(function(){
    var mode = "start";
    var stat = "prompting";
    var redirect = "index.php";
    var get_values = function(){
        return {
            "username" : $("#username-text").val(),
            "password" : $("#password-text").val()
        };
    }

    var validate = function(){
        return ! ($("#username-block").hasClass("error") 
              || $("#password-block").hasClass("error")
              || $("#confirm-block").hasClass("error"));
    };

    var check_username = function(){
        $.get("actions/check-username.php", get_values(), function(data, status){
            if(data['found']){
                $("#username-block").removeClass("success");
                $("#username-block").addClass("error");
                $("#username-help").text("Already used!");
            } else {
                $("#username-block").removeClass("error");
                $("#username-block").addClass("success");
                $("#username-help").text("OK");
            }
        }, "json");
    
    };

    var hide_all = function(){
        $("#result-modal").modal('hide');
        $("#input-modal").modal('hide');
        $("#wrap-modal").modal('hide');
        $('body').trigger("pblog-logined");
    };

    var signup = function(){
        if(validate()){
            $.post("actions/sign-up.php", get_values(), function(data, status){
                $("#result-message").html(data['message']);
                if(data['status'] === "OK"){
                    $("#result-title").text("Welcome!");
                    stat = "completed";
                } else {
                    $("#result-title").text("Sign up failed.");
                }
                $("#result-modal").modal();
            }, "json");
        } else {
            alert("Please fill out forms first");
        }
    };

    var login = function(){
        $.post("actions/login.php", get_values(), function(data, status){
            $("#result-message").html(data['message']);
            if(data['status'] === "OK"){
                $("#result-title").text("Welcome back!");
                stat = "completed";
            } else {
                $("#result-title").text("Sign up failed.");
            }
            $("#result-modal").modal();
        }, "json");
    };
    var state_login = function(){
        mode = "login";
        $("#input-title").text("Login");
        $("#input-modal").modal();
    };

    var state_signup = function(){
        mode = "signup";
        $("#confirm-block").show();
        $("#input-title").text("Sign up");
        $("#input-modal").modal();
    };

    $("#login-button").click(state_login);
    $("#signup-button").click(state_signup);
    $("#input-cancel-button").click(function(){
        $("#input-modal").modal('hide');
        $("#confirm-block").hide();
    });

    $("#input-ok-button").click(function(){
        if(mode === "signup"){
            if(validate()){
                signup();
            }
        }else if(mode === "login") {
            login();
        }
    });

    $("#result-ok-button").click(function(){
        if(stat === "completed"){
            hide_all();
        } else {
            $("#result-modal").modal('hide');
        }
    });

    $("#confirm-text").focusout(function(){
        if(mode === "signup"){
            var pass = $("#password-text").val();
            var confirm_pass = $("#confirm-text").val();
            if(pass === confirm_pass){
                $("#confirm-block").removeClass("error");            
                $("#confirm-help").text("");
                $("#input-ok-button").removeClass("disabled");
            } else {
                $("#confirm-block").addClass("error");
                $("#confirm-help").text("Different password and retyped password");
                $("#input-ok-button").addClass("disabled");
            }
        }
    });

    $("#username-text").focusout(function(){
        if(mode === "signup"){
            var username = $("#username-text").val();
            if(username.length == 0){
                $("#username-block").addClass("error");
                $("#username-help").text("Vacant is not allowed");
                $("#input-ok-button").addClass("disabled");
            } else {
                if(check_username()){
                    $("#username-block").removeClass("error");
                    $("#input-ok-button").removeClass("disabled");
                }
            }
        }
    });
});
</script>
