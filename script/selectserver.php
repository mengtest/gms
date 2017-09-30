<?php
	// 屏蔽提示
	error_reporting(E_ALL || ~E_NOTICE);

	$absolute_path = dirname(dirname(__FILE__));

	require_once("$absolute_path/config/CommomConfig.php");
	require_once("$absolute_path/config/DBList.php");
?>

<div class = 'select_div'>
<?php
	if ($_SESSION[page] == null) {
		$_SESSION[page] = 1;
	}

	// 每次都先重置总页数
	$_SESSION[totalPage] = 1;

	//function FlushPaltInfo() {
		$i = 0;
		foreach ($serverList as $plat => $idList) {
			if ($i % plat_page == 0) {
				$isShow = (($_SESSION[page] - 1) == ($i / plat_page)) ? 'block' : 'none';
				echo "<div style='display:$isShow;'><table width = '60%'>";

				if (($i / plat_page) >= $_SESSION[totalPage]) {
					$_SESSION[totalPage] = ($i / plat_page) + 1;
				}
			}

			if ($i % plat_num == 0) {
				echo "<tr>";
			}

			echo "<th> $plat";
			echo "<form action='' method='POST'> <select name='some'>";
				foreach ($idList as $serverid => $servername) {
					$select = $serverid == $_SESSION[DBIndex] ? ' selected' : '';
					echo "<option value='$serverid' $select>$servername</option>";
				}
			echo "<input name='submitse$i' type='submit' value='提交' />";
			echo "</select></form></th>";

			if ($i % plat_num == (plat_num - 1)) {
				echo "</tr>";
			}

			if ($i % plat_page == (plat_page - 1)) {
				echo "</table></div>";
			}

			$i++;
		}

		if ($i % plat_num != 0) {
			echo "</tr>";
		}

		if ($i % plat_page != 0) {
			echo "</table></div>";
		}
	//}
	//FlushPaltInfo();
?>
</div>

<div class = 'select_buttom' style = 'display:<?php echo $_SESSION[totalPage] > 1 ? "block" : "none"; ?>;'>
	<form action = '' method = 'post'>
		<input name = 'submitlast' type = 'submit' value = '上一页' />
	</form>
	<p align = 'center'><?php echo $_SESSION[page].'/'.$_SESSION[totalPage]; ?></p>
	<form action = '' method = 'post'>
		<input name = 'submitnext' type = 'submit' value = '下一页' />
	</form>
</div>

<?php
	$j = 0;
	foreach ($serverList as $plat => $idList) {
		$postname = 'submitse'.$j;
		if ($_POST[$postname]) {
			if ($_POST[some] > 0 && $_SESSION[DBIndex] != $_POST[some]) {
				$_SESSION[DBIndex] = $_POST[some];
				$_SESSION[platName] =  $plat;
			}

			break;
		}

		$j++;
	}

	if ($_SESSION[platName] != null) {
		echo "<font color='#33FF66' class = 'server_fixed'>当前选择:".$_SESSION[platName]."-".$serverList[$_SESSION[platName]][$_SESSION[DBIndex]]."</font>";
	}
	else {
		echo "<font color='#FF0000' class = 'server_fixed'>请选择服务器</font>";
	}

	if ($_POST[submitlast]) {
		if ($_SESSION[page] != null && $_SESSION[page] > 1) {
			--$_SESSION[page];
			echo "<script language = 'JavaScript'> location.reload() ; </script>";
		}
	}

	if ($_POST[submitnext]) {
		if ($_SESSION[page] != null && $_SESSION[totalPage] != null && $_SESSION[page] < $_SESSION[totalPage]) {
			++$_SESSION[page];
			echo "<script language = 'JavaScript'> location.reload() ; </script>";
		}
	}
?>