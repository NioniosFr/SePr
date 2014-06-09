<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="favicon.ico">
<title>Corporate Wiki</title>
<link rel="stylesheet"
	href="<?php echo $www['styles'].'bootstrap.css'; ?>" />
</head>
<body role="document">
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Corporate Wiki</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li <?php if ($this->activePage == 'Wiki')echo 'class="active"';?>> <a href="<?php echo $www['base']. 'wiki/'; ?>">Wiki</a></li>
					<li
						<?php if ($this->activePage == 'Login')echo 'class="active"';?>> <a href="<?php echo $www['base'].'user/'; ?>">Login</a></li>
					<li
						<?php if ($this->activePage === '')echo 'class="active"';?>><a href="<?php echo $www['base'].'error/'; ?>">Error</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Nav header</li>
							<li><a href="#">Separated link</a></li>
							<li><a href="#">One more separated link</a></li>
						</ul></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	<div id="content" class="container" role="main"
		style="margin-top: 50px;">