<?php
if (! defined('CW'))
    exit('invalid access');

?>
<h2>Login Form</h2>
<br />
<div class="col-md-2"></div>
<div id="form-container" class="col-md-10">
	<form id="loginForm" accept-charset="utf-8" method="post" role="form"
		action="<?php echo $www['base'].'user/login'; ?>">
		<div class="input text row ">
			<div class="col-md-5">
				<label class="control-label" for="user">User Name: </label> <input
					id="mail" class="form-control" type="text" name="mail" value="" />
			</div>
		</div>
		<div class="form-group">
			<div class="input text row">
				<div class="col-md-5">
					<label class="control-label" for="pass">Password: </label> <input
						id="pass" class="form-control" type="password" name="pass"
						value="" />
				</div>
			</div>
		</div>
		<br />
		<div class="submit">
			<input class="btn btn-md btn-primary" type="submit" value="Login">
		</div>
	</form>
</div>
