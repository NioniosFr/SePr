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

<div class="table-responsive col-md-12">
	<table class="table table-hover ">
		<thead>
			<tr class="">
				<th class="">Id</th>
				<th>Title</th>
				<th>Content</th>
				<th>Last Edited by</th>
				<th class="">Action</th>
			</tr>
		</thead>
	<?php
foreach ($this->params['pages'] as $page) {
    echo "<tr href='wiki/'>";
    echo "";
    echo "<td class='active'>{$page['id']}</td>";
    echo "<td class=''>{$page['title']}</td>";
    echo '<td class="">';
    echo "<a href='{$www['base']}{$page['action']['view']}'/>" . htmlspecialchars(substr($page['content'], 0, 160)) . "</a>";
    echo (strlen($page['content']) > 160) ? '&nbsp;. . . </td>' : '</td>';
    echo "<td class=''>{$page['lastEditor']}</td>";
    echo "<td class='col-md-2'>";
    echo "<a role='button' class='btn btn-warning btn-xs'href='{$www['base']}{$page['action']['edit']}'>Edit</a>";
    echo "&nbsp;";
    echo "<a role='button' class='btn btn-danger btn-xs'href='{$www['base']}{$page['action']['delete']}'>Delete</a>";
    echo "</td>";
    echo "</tr>";
}
?>
	</table>
</div>
