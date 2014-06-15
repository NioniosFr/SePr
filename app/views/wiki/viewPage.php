<?php
if (! defined('CW'))
    exit('invalid access');

?>

<h2>
<?php echo $this->params['page']['title'];?>
</h2>
<div>
<?php
// Define lines.
// Characters per line.
$line = 80;
// Lines per paragraph
$linesPerPar = 8;
// Break the lines
$text = wordwrap($this->params['page']['content'], $line, '<br />');

$text_to_echo = strlen($text);
while ($text_to_echo > 0) {
    echo '<p>';
    // Echo as many characters as the lines per paragraph.
    echo $paragraph = substr($text, 0, $line * $linesPerPar);
    echo '</p>';
    $text_to_echo -= $line * $linesPerPar;
}
?>
</div>
<div>
	<blockquote class="blockquote-reverse">

	<?php
echo "<a href='{$www['base']}wiki/' class='btn btn-primary btn-sm' role='button'>Back</a>";
echo "&nbsp;";
echo "<a href='{$www['base']}{$this->params['page']['action']['edit']}' class='btn btn-warning btn-sm' role='button'>Edit</a>";
echo "&nbsp;";
echo "<a href='{$www['base']}{$this->params['page']['action']['delete']}' class='btn btn-danger btn-sm' role='button'>Delete</a>";

?>
<br />
		<p>
			Page created @ <em><?php echo $this->params['page']['created']; ?></em>
		</p>
		<footer>
			Last editor:<strong><em> <?php echo $this->params['page']['lastEditor'];?> </em></strong>@
			<em><?php echo $this->params['page']['modified']; ?></em>
		</footer>
	</blockquote>
</div>