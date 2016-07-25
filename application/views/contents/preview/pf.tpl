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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>

</head>

<div>
  <section class="container">
  <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
  <div class="row">

  </div>

<body>

<H3><p class="bg-info">事業者プラットフォーム</p></H3>

	<div class="form-group">
	  {$list.en_title01}
	</div>
	<div class="form-group">
	  {$list.en_body01}
	</div>
	<div class="form-group">
	  {$list.en_title02}
	</div>
	<div class="form-group">
	  {$list.en_body02}
	</div>
	<div class="form-group">
	  {$list.en_cate01}
	</div>
	<div class="form-group">
	  {$list.en_cate02}
	</div>
	<div class="form-group">
	  {$list.en_cate03}
	</div>
	<div class="form-group">
	  {$list.en_shopname}
	</div>
	<div class="form-group">
	  {$list.en_shopname_sub}
	</div>
	<div class="form-group">
	  {$list.en_url}
	</div>
	<div class="form-group">
	  {$list.en_zip01} {$list.en_zip02}
	</div>
	<div class="form-group">
	  {$list.en_pref} {$list.en_addr01} {$list.en_addr02} {$list.en_buil}
	</div>
	<div class="form-group">
	  {$list.en_tel}
	</div>
	<div class="form-group">
	  {$list.en_mail}
	</div>
	<div class="form-group">
	  {$list.en_opentime}
	</div>
	<div class="form-group">
	  {$list.en_holiday}
	</div>
	<div class="form-group">
	  {$list.en_since}
	</div>
	<div class="form-group">
	  {$list.en_parking}
	</div>
	<div class="form-group">
	  {$list.en_seat}
	</div>
	<div class="form-group">
	  {$list.en_card}
	</div>
	<div class="form-group">
	  {$list.en_access}
	</div>
	<div class="form-group">
	  {$list.en_access_sub}
	</div>
	<div class="form-group">
	  {$list.en_contents01}
	</div>
	<div class="form-group">
	  {$list.en_contents02}
	</div>
	<div class="form-group">
	  {$list.en_description}
	</div>
	<div class="form-group">
	  {$list.en_keywords}
	</div>
	<div class="form-group">
	  {$list.en_sns01}
	</div>
	<div class="form-group">
	  {$list.en_sns02}
	</div>
	<div class="form-group">
	  {$list.en_sns03}
	</div>
	<div class="form-group">
	  {$list.en_sns04}
	</div>
	<div class="form-group">
	  {$list.en_sns05}
	</div>
	<div id="gmap" style="width : 500px; height : 500px;"></div>{$list.en_google_map}
	<div class="form-group">
	  {$list.en_free01}
	</div>
	<div class="form-group">
	  {$list.en_free02}
	</div>
	<div class="form-group">
	  {$list.en_free03}
	</div>
	<div class="form-group">
	  {$list.en_free04}
	</div>
	<div class="form-group">
	  {$list.en_free05}
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
