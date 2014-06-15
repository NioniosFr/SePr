<?php
if (! defined('CW'))
    exit('invalid access');
?>

<h2>Wiki</h2>

<p>You can select a page from the table below to view its full content.</p>
<p>
	<a href='<?php echo $www['base'].'/wiki';?>'
		class='btn btn-info btn-sm' role='button'>Refresh page list</a>
</p>
<?php if (!isset($this->params['pages'])) return ; ?>

<div class="table-responsive">
	<table class="table table-hover">
		<tbody>


		<thead>
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Content</th>
				<th>Last Edited by</th>
				<th>Action</th>
			</tr>
		</thead>
	<?php
foreach ($this->params['pages'] as $page) {
    echo "<tr>";
    // echo "<a href='{$www['base']}{$page['action']['view']}'>";
    echo "<td class='active'>{$page['id']}</td>";
    echo "<td class='active'>{$page['title']}</td>";
    echo '<td class="active">';
    echo substr($page['content'], 0, 160);
    echo (strlen($page['content']) > 160) ? '&nbsp;. . . </td>' : '</td>';
    echo "<td class='active'>{$page['lastEditor']}</td>";
    echo "<td class='active'><a href='{$www['base']}{$page['action']['view']}'>View</a>, <a href='{$www['base']}{$page['action']['edit']}'>Edit</a>, <a href='{$www['base']}{$page['action']['delete']}'>Delete</a></td>";
    // echo "</a>";
    echo "</tr>";
}
?>
</tbody>
	</table>
</div>
