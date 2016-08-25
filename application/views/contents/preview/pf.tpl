<!DOCTYPE html>
<html class="no-js" lang="jp">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>プラットフォーム &#xB7; FNOTE</title>

{* Versionと並び順に注意 *}
<link href="{base_url()}../../css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{base_url()}../../js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDrmCOpsdAhrxRTHwHz9dnGGR-Ug73SzrA"></script>
{*<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>*}

</head>

<div>
  <section class="container">
  <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
  <div class="row">

  </div>

<body>

<H3><p class="bg-info">事業者プラットフォーム</p></H3>

	<div class="form-group">
	  {$list.ep_title01}
	</div>
	<div class="form-group">
	  {$list.ep_body01}
	</div>
	<div class="form-group">
	  {$list.ep_title02}
	</div>
	<div class="form-group">
	  {$list.ep_body02}
	</div>
	<div class="form-group">
	  {$list.ep_cate}
	</div>
	<div class="form-group">
	  {$list.ep_shopname}
	</div>
	<div class="form-group">
	  {$list.ep_shopname_sub}
	</div>
	<div class="form-group">
	  {$list.ep_url}
	</div>
	<div class="form-group">
	  {$list.ep_zip01} {$list.ep_zip02}
	</div>
	<div class="form-group">
	  {$list.ep_pref} {$list.ep_addr01} {$list.ep_addr02} {$list.ep_buil}
	</div>
	<div class="form-group">
	  {$list.ep_tel}
	</div>
	<div class="form-group">
	  {$list.ep_mail}
	</div>
	<div class="form-group">
	  {$list.ep_opentime}
	</div>
	<div class="form-group">
	  {$list.ep_holiday}
	</div>
	<div class="form-group">
	  {$list.ep_since}
	</div>
	<div class="form-group">
	  {$list.ep_parking}
	</div>
	<div class="form-group">
	  {$list.ep_seat}
	</div>
	<div class="form-group">
	  {$list.ep_card}
	</div>
	<div class="form-group">
	  {$list.ep_access}
	</div>
	<div class="form-group">
	  {$list.ep_access_sub}
	</div>
	<div class="form-group">
	  {$list.ep_contents01}
	</div>
	<div class="form-group">
	  {$list.ep_contents02}
	</div>
	<div class="form-group">
	  {$list.ep_description}
	</div>
	<div class="form-group">
	  {$list.ep_keywords}
	</div>
	<div class="form-group">
	  {$list.ep_sns01}
	</div>
	<div class="form-group">
	  {$list.ep_sns02}
	</div>
	<div class="form-group">
	  {$list.ep_sns03}
	</div>
	<div class="form-group">
	  {$list.ep_sns04}
	</div>
	<div class="form-group">
	  {$list.ep_sns05}
	</div>
	{if $list.ep_google_map}<div id="gmap" style="width : 500px; height : 500px;"></div>{$list.ep_google_map}{/if}
	<div class="form-group">
	  <img src='/qr/qr_pre/{$list.ep_seq}' />
	</div>
	<div class="form-group">
	  {$list.ep_free01}
	</div>
	<div class="form-group">
	  {$list.ep_free02}
	</div>
	<div class="form-group">
	  {$list.ep_free03}
	</div>
	<div class="form-group">
	  {$list.ep_free04}
	</div>
	<div class="form-group">
	  {$list.ep_free05}
	</div>

</section>


<br><br>
<div class="panel panel-default">
  <div class="panel-footer text-center">
    Copyright(C) 2016 - {{$smarty.now|date_format:"%Y"}} Themis Inc. All Rights Reserved.
  </div>
</div>

</body>
</html>
