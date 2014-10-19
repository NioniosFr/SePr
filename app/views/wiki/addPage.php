<?php
if (! defined('CW'))
    exit('invalid access');
$this->scripts['tinymce-4.1.6'] = '//tinymce.cachefly.net/4.1/tinymce.min.js';
$this->inline_scripts['tinymce-init'] = "tinymce.init({selector:'textarea'});";
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
				<input class="btn btn-md btn-warning" type="reset" value="Clear">
				&nbsp;
				<a href="<?php echo $www['base'].'wiki'; ?>" class='btn btn-danger btn-sm' role='button'>Cancel</a>
				<input class="btn btn-md btn-success pull-right" type="submit" value="Save">
			</div>
		</div>
	</form>

</div>