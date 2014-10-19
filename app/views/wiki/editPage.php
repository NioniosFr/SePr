<?php
if (! defined('CW'))
    exit('invalid access');
$this->scripts['tinymce-4.1.6'] = '//tinymce.cachefly.net/4.1/tinymce.min.js';
$this->inline_scripts['tinymce-init'] = "tinymce.init({selector:'textarea'});";
?>

<h2>Update Page</h2>
<br />
<div id="form-container" class="col-md-10">
	<form id="editPage" accept-charset="utf-8" method="post" role="form"
		action="<?php echo $www['base'].$this->params['page']['action']['edit']; ?>">
		<div class="form-group">
			<div class="input text row ">
				<label class="control-label" for="title">Title: </label><input
					class="form-control" type="text" name="title"
					value="<?php echo $this->params['page']['title'];?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="input text row ">
				<label class="control-label" for="user">Content: </label>
				<textarea name="content" class="form-control" rows="3"><?php echo $this->params['page']['content'];?></textarea>
			</div>
		</div>
		<div class="form-group">
			<input type="hidden" name="hi"
				value="<?php echo $this->params['page']['id']; ?>" />
			<?php echo "<a href='{$www['base']}{$this->params['page']['action']['view']}' class='btn btn-danger btn-sm' role='button'>Back</a>"; ?>
				<div class="submit">
				<input class="btn btn-md btn-success pull-right" type="submit"
					value="Update" />
			</div>
		</div>
	</form>
</div>
