<?php
if (! defined('CW'))
    exit('invalid access');
?>

<h2>Add New Page</h2>
<br />
<div id="form-container" class="col-md-10">
	<form id="addPage" accept-charset="utf-8" method="post" role="form"
		action="<?php echo $www['base'].'wiki/add'; ?>">
		<div class="form-group">
			<div class="input text row ">
				<label class="control-label" for="title">Title: </label><input
					class="form-control" type="text" name="title" value="" />
			</div>
		</div>
		<div class="form-group">
			<div class="input text row ">
				<label class="control-label" for="user">Content: </label>
				<textarea name="content" class="form-control" rows="3"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="submit">
				<input class="btn btn-md btn-danger" type="reset" value="Cancel"> <input
					class="btn btn-md btn-success pull-right" type="submit"
					value="Save">
			</div>
		</div>
	</form>

</div>