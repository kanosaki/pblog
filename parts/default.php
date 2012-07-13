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
				<div class="span9">
					<?php require $page_body; ?>
				</div><!--/span-->
				<div class="span3">
					<?php require 'sidebar.php'; ?>
				</div><!--/span-->
			</div><!--/row-->

			<hr>

			<?php require 'footer.php' ?>
		</div><!--/.fluid-container-->
        
	</body>
</html>
