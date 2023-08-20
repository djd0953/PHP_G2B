<!doctype html>
<html>
<head>
<title>조달청-나라장터 조회 서비스</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style>
	html, body
	{
		width:100%;
		height:99%;

		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-ms-box-sizing: border-box;
		-o-box-sizing: border-box;
		-webkit-box-sizing: border-box;
	}

	.cs_frame_box
	{
		width:100%;
		height:100%;
		font-size:16px;
		overflow:auto;
		background-color:#fff;

		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-ms-box-sizing: border-box;
		-o-box-sizing: border-box;
		-webkit-box-sizing: border-box;
	}
	.cs_frame 
	{
		width:100%;
		height:100%;
		padding:35px;

		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-ms-box-sizing: border-box;
		-o-box-sizing: border-box;
		-webkit-box-sizing: border-box;	
	}
	.cs_datatable 
	{
		width:100%;
		table-layout:fixed;
		border:1px solid #cfcfcf;
		box-shadow:0px 5px 3px 3px #ebebeb;
		background-color:#fff;
		text-align:center;
		font-size:12px;
		margin-top:10px;
	}
	.cs_datatable th 
	{
		color:#fff;
		font-weight:bold;
		font-size: 13px;
		height:35px;
		border:1px solid #cfcfcf;
	}
	.cs_datatable td 
	{
		height:25px;
		border:1px solid #cfcfcf;
	}
	.cs_selectBox 
	{
		width:100%;
		height:200px;
		position:relative;
	}

	.cs_selectBox .cs_unit 
	{
		font-size:12px;
		color:#939393;
		font-weight:bold;
	}

	.cs_selectBox .cs_date 
	{
		position:absolute;right:0px;top:-6px;
	}

	.cs_page
	{	
		width: 99%;
		text-align: center;
		margin-top: 55px;
		line-height:38px;

		display:flex;
		justify-content: center;
	}

	.cs_page div
	{
		text-decoration: none;
		border: 1px solid #ccc;
		padding: 4px 8px;
		margin-right: 2px;
		font-size: 12px;
		color: #333;
		cursor:pointer;
	}

	.cs_page div:last-child
	{
		margin-right: 0px;
	}

	.cs_page .active, .cs_pages:hover
	{
		background-color:#ccc;
	}

	img
	{
		width:200px;
	}
</style>
<link rel="shortcut icon" href="/image/favicon.ico">	<!-- ico 파일 -->

</head>
<body>
	<div class="cs_frame_box" id="id_frame_box">
		<div class="cs_frame">
			<div class="cs_selectBox">
				<div class="cs_date">
					<form name="date" id="id_form" method="get" action="" style="display:flex;justify-content: center;">
						<table class="cs_datatable" border="0" cellpadding="0" cellspacing="0" rules="rows" style="border:1px solid #738bd5; margin-top:0px; width:80%;">
							<tr>
								<td colspan="2">
									<select name="type" id="type" style="width:60%;height:30px;font-size:20px;line-height:33px; text-align:center">
										<option value="1">다수공급계약 품목정보 조회</option>
										<option value="2">제3자 단가계약 품목정보 조회</option>
										<option value="3">종합쇼핑몰 품목 정보 목록 조회</option>
										<option value="4">벤처나라 물품 주문거래 내역 조회</option>
									</select>
								</td>
								<th style="background-color:#738bd5;">등록년도</th>
								<td>
									<select name="year" id="year" style="height:30px;font-size:20px;line-height:33px;">
										<?php 
										for($y = date("Y", time()); $y >= 2000; $y--) 
										{
											if(date("Y", time()) == $y) {$selected = "selected";} else {$selected = "";}
										?>
											<option value="<?=$y?>"<?=$selected?>><?=$y?></option>
										<?php 
										} ?>
									</select> 년 &nbsp;&nbsp;
								</td>
								<th rowspan="4" id="src" width="5%" style="background-color:#738bd5;cursor:pointer;">검색</th>
								<th rowspan="4" id="excel" width="5%" style="background-color:#738bd5;cursor:pointer;">엑셀</br>다운!</th>
							</tr>
							<tr>
								<th style="background-color:#738bd5;">품명</th>
								<td colspan="3"><input type="textbox" class="txt" id="name" value="" style="width:80%;height:24px;font-size:20px;" placeholder="ex)기타화초"></td>
							</tr>
							<tr class="List1 List2">
								<th style="background-color:#738bd5;">계약업체명</th>
								<td><input type="textbox" class="txt" id="cnt" value="" style="height:24px;font-size:20px;" placeholder="ex)꽃사랑 영농조합법인"></td>
								<th style="background-color:#738bd5;">제품인증여부</th>
								<td><input type="checkbox" class="txt" id="prod" value="" style="zoom:1.8;" checked></td>
							</tr>
							<tr class="List1 List2">
								<th style="background-color:#738bd5;">식별번호</th>
								<td><input type="textbox" class="txt" id="num" value="" style="height:24px;font-size:20px;" placeholder="ex)22202231"></td>
								<th style="background-color:#738bd5;">변경년도</th>
								<td>
									<input type="checkbox" class="txt" id="chgdyn" value="" style="zoom:1.8;">
									<select name="chgd" id="chgd" style="height:30px;font-size:20px;line-height:33px;" disabled>
										<?php 
										for($y = date("Y", time()); $y >= 2000; $y--) 
										{
											if(date("Y", time()) == $y) {$selected = "selected";} else {$selected = "";}
										?>
											<option value="<?=$y?>"<?=$selected?>><?=$y?></option>
										<?php 
										} ?>
									</select> 년 &nbsp;&nbsp;
								</td>
							</tr>
							<tr class="List3" style="display:none;">
								<th style="background-color:#738bd5;">조회구분</th>
								<td>
									<select name="selType" id="selType" style="width:60%;height:30px;font-size:20px;line-height:33px; text-align:center">
										<option value="1" selected>등록일자 검색</option>
										<option value="2">쇼핑계약번호</option>
									</select>
								</td>
								<th style="background-color:#738bd5;">우수제품여부</th>
								<td><input type="checkbox" class="txt" id="excl" value="" style="zoom:1.8;"></td>
							</tr>
							<tr class="List3 List4" style="display:none;">
								<th style="background-color:#738bd5;">세부품명</th>
								<td><input type="textbox" class="txt" id="dtil" value="" style="height:24px;font-size:20px;" placeholder="ex)이동형파일서랍"></td>
								<th style="background-color:#738bd5;">물품규격명</th>
								<td><input type="textbox" class="txt" id="prdc" value="" style="height:24px;font-size:20px;"placeholder="ex)크로바기구"></td>
							</tr>
							<tr class="List3" style="display:none;">
								<th style="background-color:#738bd5;">다수공급경쟁자여부</th>
								<td><input type="checkbox" class="txt" id="mas" value="" style="zoom:1.8;" checked></td>
								<th style="background-color:#738bd5;">제품인증여부</th>
								<td><input type="checkbox" class="txt" id="prod2" value="" style="zoom:1.8;" checked></td>
							</tr>
							<tr class="List3" style="display:none;">
								<th id="shopEsse" style="background-color:#738bd5;">쇼핑계약번호</th>
								<td><input type="textbox" class="txt" id="shop" value="" style="height:24px;font-size:20px;"placeholder="계약번호(9)+차수(2) 11자리"></td>
								<th style="background-color:#738bd5;">등록해지여부</th>
								<td><input type="checkbox" class="txt" id="regt" value="" style="zoom:1.8;"></td>
							</tr>
							<tr class="List4" style="display:none;">
								<th style="background-color:#738bd5;">수요기관명</th>
								<td><input type="textbox" class="txt" id="dmin" value="" style="height:24px;font-size:20px;" placeholder="ex)충청남도교육청"></td>
								<th style="background-color:#738bd5;">수요기관지역명</th>
								<td><input type="textbox" class="txt" id="dminNm" value="" style="height:24px;font-size:20px;" placeholder="ex)아산시"></td>
							</tr>
						</table>
					</form>
				</div>
			</div> <?php //selectBox?>

			<div class="cs_page">
			</div>
			
			<form name="form" id="sendform" method="post" action="dataExcel.php" style="margin-top:30px;">
				<table class="cs_datatable" border="0" cellpadding="0" cellspacing="0" rules="rows" style="border:1px solid #738bd5;">
					<tbody id="tbody">
						<tr style="position:sticky;top:0px; background-color: #738bd5;">
							<th width="40%">이미지</th>
							<th>계약업체명</th>
							<th>물품규격명</th>
							<th>계약가격금액</th>
							<th>물품원산지명</th>
							<th>물품제조사명</th>
						</tr>
					</tbody>
				</table>
			</form>
		</div> <?php //frame?>
	</div>
    
   	<script src="/js/jquery-1.9.1.js"></script>
	<script src="./g2bscr.js"></script>
</body>
</html>
