<?php global $www, $view, $error; ?>
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
				<a class="navbar-brand" href="<?php echo $www['base']; ?>">Corporate Wiki</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li <?php if ($this->activePage == 'Wiki')echo 'class="active"';?>>
						<a href="<?php echo $www['base']. 'wiki/'; ?>">Wiki</a>
					</li>
					<li <?php if ($this->activePage == 'Login')echo 'class="active"';?>>
						<a href="<?php echo $www['base'].'user/'; ?>">Login</a>
					</li>
					<li <?php if ($this->activePage === '')echo 'class="active"';?>><a
						href="<?php echo $www['base'].'error/'; ?>">Error</a></li>
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
		<div id="container">
			<div id="header"></div>
			<div class="col-md-2">
				<p></p>
			</div>
			<div class="row">
				<div class="col-md-8">
					<h1>Welcome to the Corporate Wiki!</h1>
					<div class="row">
						<div><?php echo $error->printErrorMsg(); ?></div>
            <?php include_once $view->file; ?>
            </div>
				</div>
			</div>
			<div class="col-md-2">
				<p></p>
			</div>
		</div>