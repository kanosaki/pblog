<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
            <a class="brand" href="#">P-Blog</a>
<?php if($session->is_logined()){ ?>
            <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> <?php echo $session->user_name(); ?> <span class="caret"></span> </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">Sign Out</a>
                    </li>
                </ul>
            </div>
<?php } else { ?>
            <div class="pull-right">
                <a href="login.php" class="btn">Login</a>
            </div>            
<?php } ?>
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
