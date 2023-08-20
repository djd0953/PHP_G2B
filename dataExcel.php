<?php
	if(isset($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else $ip = $_SERVER['REMOTE_ADDR'];
	$_SESSION['ip'] = $ip;
	
	$cnt = $_POST['sendcnt'];
	$name = $_POST['name'];
	$year = $_POST['year'];
	$page = $_POST['page'];
	
	$cntrctCorpNm = array();
	$prdctSpecNm = array();
	$cntrctPrceAmt = array();
	$prdctOrgplceNm = array();
	$prdctMakrNm = array();

	for($i = 0; $i < $cnt; $i++)
	{
		$prdctImgUrl['prdctImgUrl'.$i] = $_POST['prdctImgUrl'.$i];
		$cntrctCorpNm['cntrctCorpNm'.$i] = $_POST['cntrctCorpNm'.$i];
		$prdctSpecNm['prdctSpecNm'.$i] = $_POST['prdctSpecNm'.$i];
		$cntrctPrceAmt['cntrctPrceAmt'.$i] = $_POST['cntrctPrceAmt'.$i];
		$prdctOrgplceNm['prdctOrgplceNm'.$i] = $_POST['prdctOrgplceNm'.$i];
		$prdctMakrNm['prdctMakrNm'.$i] = $_POST['prdctMakrNm'.$i];
	}

	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename="."나라장터_{$name}물품조회_{$year}_{$page}Page.xls");
	header("Content-Description:PHP5 Generated Data");
	header('Content-Type: text/html; charset=UTF-8');
?>

<table border="1">
	<tr>
		<th style="width:100px;background-color:#738bd5;">이미지</th>
		<th style="background-color:#738bd5;">계약업체명</th>
		<th style="background-color:#738bd5;">물품규격명</th>
		<th style="background-color:#738bd5;">계약가격금액</th>
		<th style="background-color:#738bd5;">물품원산지명</th>
		<th style="background-color:#738bd5;">물품제조사명</th>
	</tr>

	<?php
	if($cnt > 0)
	{
		for($i = 0; $i < $cnt; $i++)
		{
			echo "<tr>";
			echo "<td style='height:100px;'><img height=98 src='{$prdctImgUrl['prdctImgUrl'.$i]}'></td>";
			echo "<td>".$cntrctCorpNm['cntrctCorpNm'.$i]."</td>";
			echo "<td>".$prdctSpecNm['prdctSpecNm'.$i]."</td>";
			echo "<td>".$cntrctPrceAmt['cntrctPrceAmt'.$i]."</td>";
			echo "<td>".$prdctOrgplceNm['prdctOrgplceNm'.$i]."</td>";
			echo "<td>".$prdctMakrNm['prdctMakrNm'.$i]."</td>";
			echo "</tr>";
		}
	}
	?>
</table>

<?php echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> "; ?>