<?php
if (! defined('CW'))
    exit('invalid access');

?>
	<h2>Login Form</h2>
	<form id="loginForm" accept-charset="utf-8" method="post"
		role="form" action="<?php echo $www['base'].'user/login'; ?>">
			<div class="input text">
				<label class="control-label" for="user">User Name: </label> <input
					id="user" type="text" name="user" value="" />
			</div>
		<div class="form-group">
			<div class="input text">
				<label class="control-label" for="pass">Password: </label> <input
					id="pass" type="password" name="pass" value="" />
			</div>
		</div>
	<br />
	<div class="submit">
		<input class="btn btn-md btn-primary" type="submit" value="Login">
	</div>
</form>