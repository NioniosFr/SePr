<?php global $www, $view, $error, $session; ?>
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
				<a class="navbar-brand" href="<?php echo $www['base']; ?>">Corporate
					Wiki</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li <?php if ($this->activePage == 'wiki')echo 'class="active"';?>>
						<a href="<?php echo $www['base']. 'wiki/'; ?>">Wiki</a>
					</li>

					<li
						<?php

    if ($this->activePage == 'login' || $this->activePage == 'logout')
        echo 'class="active"';
    ?>><?php

    if ($session->loggedIn) {
        echo "<a href='{$www['base']}user/logout'>Logout</a>";
    } else {
        echo "<a href='{$www['base']}user/'>Login</a>";
    }
    echo '</li>';
    ?>
					<li
						<?php if ($this->activePage === 'myAccount')echo 'class="active"';?>><a
						href="<?php echo $www['base'].'user/myAccount'; ?>">My Account</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown">Wiki<b
							class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $www['base'].'wiki/'; ?>">View All Pages</a></li>
							<li><a href="<?php echo $www['base'].'wiki/addPage'; ?>">Add new
									Page</a></li>
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
					<br />
					<div class="row">
					<?php if (isset($_SESSION['SUCCESS'])):?>
                    <div class="alert alert-success">
							<p><?php echo $_SESSION['SUCCESS'];?></p>
						</div>
                <?php endif;?>
                <?php if (isset($_SESSION['NOTICE'])):?>
                    <div class="alert alert-info">
							<p><?php echo $_SESSION['NOTICE'];?></p>
						</div>
                <?php endif;?>
						<div><?php echo $error->printErrorMsg(); ?></div>
            <?php include_once $view->file; ?>
            </div>
				</div>
			</div>
			<div class="col-md-2">
				<p></p>
			</div>
		</div>