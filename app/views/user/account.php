<?php
if (! defined('CW'))
    exit('invalid access');
?>

<h2>My account</h2>
<h3>Account Details:</h3>
<div>
	<p>
		<strong class="text-info">User Name: </strong><span><?php echo $this->params['user']['name'];?></span>
	</p>
	<p>
		<strong class="text-info">User EMail: </strong><span><?php echo $this->params['user']['mail'];?></span>
	</p>
</div>
<br />
<h3>Pages I was the last editor of:</h3>
<div>
<?php

if (count($this->params['edits']) <= 0) {
    echo "<p class='text-info'>You weren't the last editor of any page.</p>";
} else {
    ?>
<table class="table table-hover">
		<thead>
			<tr>
				<th>#ID</th>
				<th>Created</th>
				<th>Modified</th>
				<th>Title</th>
				<th>Action</th>
			</tr>
		</thead><?php
    // Single depth array.
    if (isset($this->params['edits']['page_id'])) {
        $page = $this->params['edits'];
        echo "<tr>";
        echo "<td>{$page['page_id']}</td>";
        echo "<td>{$page['created']}</td>";
        echo "<td>{$page['modified']}</td>";
        echo "<td>{$page['title']}</td>";
        echo "<td><a href='{$www['base']}wiki/view/?id={$page['page_id']}'>View</a>,&nbsp;<a href='{$www['base']}wiki/edit/?id={$page['page_id']}'>Edit</a></td>";
        echo "<tr>";
    } else {
        // Multidimensional
        foreach ($this->params['edits'] as $page) {
            echo "<tr>";
            echo "<td>{$page['page_id']}</td>";
            echo "<td>{$page['created']}</td>";
            echo "<td>{$page['modified']}</td>";
            echo "<td>{$page['title']}</td>";
            echo "<td><a href='{$www['base']}wiki/view/?id={$page['page_id']}'>View</a>,&nbsp;<a href='{$www['base']}wiki/edit/?id={$page['page_id']}'>Edit</a></td>";
            echo "<tr>";
        }
    }
    ?>
    </table><?php
}
?>
</div>
<br />
<h3>Permissions</h3>
<div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Create</th>
				<th>Read</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
<?php
$permissions = $this->params['permissions'];
?>
<tr>
			<td
				class="active <?php echo $permissions['create']? 'success' : 'danger'; ?>"><?php echo $permissions['create']? 'Yes' : 'No'; ?></td>
			<td
				class="active <?php echo $permissions['read']? 'success' : 'danger'; ?>"><?php echo $permissions['read']? 'Yes' : 'No'; ?></td>
			<td
				class="active <?php echo $permissions['update']? 'success' : 'danger'; ?>"><?php echo $permissions['update']? 'Yes' : 'No'; ?></td>
			<td
				class="active <?php echo $permissions['delete']? 'success' : 'danger'; ?>"><?php echo $permissions['delete']? 'Yes' : 'No'; ?></td>
		</tr>
	</table>
</div>