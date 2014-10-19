
<div style="clear: both;">
	<br /> <br />
</div>
<div id="footer">
<?php
foreach ( $this->styles as $style => $href ) {
	echo "<link rel='stylesheet' href='$href' />\n";
}
foreach ( $this->scripts as $script => $src ) {
	echo "<script type='text/javascript' src='$src'></script>\n";
}
foreach ($this->inline_scripts as $script => $code){
	echo "<script type='text/javascript'>$code</script>\n";
}
?>
</div>
</div>
</body>
</html>
