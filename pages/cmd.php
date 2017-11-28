<?php
	$Title = "这里是cmd";
	require_once("../html/header.html");
?>
<script language = 'JavaScript'>
var is_scroll = true;
var is_first = true;
function refresh()
{
	if(is_first || is_scroll)
	{
		is_first = false;
		scroll(0, document.body.scrollHeight);
	}
}

var handler = setInterval(refresh,100);
window.onload = function(){
	clearInterval(handler);
	refresh();
};
</script>
<?php
	echo "<div >";
	ob_end_flush ();
	echo '<pre>';

	function root_exec($cmd, $ret=null)
	{
		//system('echo "zxc123qwe" | sudo -u www -S sh ../ssl.sh '.$cmd.' 2>&1', $ret);
		system('sh ../ssl.sh '.$cmd.' 2>&1', $ret);
	}

	if ($_POST[submit]) {
		//root_exec("/3dmmo/Server ".$_POST[cmd]);
		root_exec($_POST[option_type]." ".$_POST[param]);
	}
	echo '</pre>';
	echo "</div>";

	$OptionType = array(
		"svn更新" => "/3dmmo/Server svn up",
		"svn信息" => "/3dmmo/Server svn log",
		"编译" => "/3dmmo/Server ls",
		"启动服务器" =>"/3dmmo/Server ls -a",
		"关闭服务器" =>"~ ls -a 2>&1",
	);
?>
<div style=" position:fixed; left:35%; top:15%; width:100%;">
<form action="" method="post">
 	<!--cmd：<input name="cmd" type="text" />-->
	<select name="option_type">
	<?php
		foreach ($OptionType as $key => $value) {
			echo "<option value='$value' >$key</option>";
 		}
	?>
	</select>
	<input name="param" type="text" />
 	<input name="submit" type="submit" value="submit" />
</form>
</div>
<?php
	require_once("../html/bottom.html");
?>
