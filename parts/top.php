<!doctype html>
<html>
	<head>
		<?php require 'common-head.php'; ?>
	</head>
	<body>
		<?php require 'navbar.php'; ?>
		<div id="top-padding" style="height: 50px;"></div>
        <div id="alert-area"></div>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span9">
					<div class="hero-unit">
						<h1>Welcome to P-Blog!</h1>
						<p>
							Welcome! but this site is not available.
						</p>
						<p>
							<a class="btn btn-primary btn-large" href="article.php">Learn more &raquo;</a>
						</p>
					</div>
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
