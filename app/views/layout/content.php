<?php global $www, $view, $error; ?>

<div id="container">
	<div id="header"></div>
	<div class="col-md-2">
			<p></p>
		</div>

	<div class="row">
		<div class="col-md-8">
			<h1>Welcome to the Corporate Wiki!</h1>
			<div class="row">
				<p><?php echo $error->printErrorMsg(); ?></p>
            <?php include_once $view->file; ?>
            </div>
		</div>

	</div>
	<div class="col-md-2">
			<p></p>
		</div>
</div>
