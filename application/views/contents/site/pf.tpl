<!DOCTYPE html>
<html class="no-js" lang="jp">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>CS &#xB7; Crowd Sourcing</title>

{* Versionと並び順に注意 *}
<link href="{base_url()}../../css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{base_url()}../../js/bootstrap.min.js"></script>


<script src="https://maps.googleapis.com/maps/api/js?sensor=FALSE"></script>
	<script type="text/javascript">
		google.maps.event.addDomListener(window, 'load', function() {
			var map = document.getElementById("gmap");
			var options = {
				zoom: 16,
				center: new google.maps.LatLng(35.657198, 139.695597),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			new google.maps.Map(map, options);
		});
	</script>
</head>


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

<section class="container">

<H3><p class="bg-info">問合せフォーム</p></H3>
{form_open('site/inquiry_conf/' , 'name="InquiryForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="co_contact_name" class="col-sm-3 control-label">お名前<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('co_contact_name' , set_value('co_contact_name', '') , 'class="form-control" placeholder="お名前を入力してください"')}
      {if form_error('co_contact_name')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_name')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="co_contact_mail" class="col-sm-3 control-label">メールアドレス<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('co_contact_mail' , set_value('co_contact_mail', '') , 'class="form-control" placeholder="ご利用プランを入力してください"')}
      {if form_error('co_contact_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_mail')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="co_contact_tel" class="col-sm-3 control-label">電話番号</label>
    <div class="col-sm-8">
      {form_input('co_contact_tel' , set_value('co_contact_tel', '') , 'class="form-control" placeholder="ご利用プランを入力してください"')}
      {if form_error('co_contact_tel')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_tel')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="co_contact_body" class="col-sm-3 control-label">お問合せ内容<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {$attr01['name'] = 'co_contact_body'}
      {$attr01['rows'] = 10}
      {form_textarea($attr01 , set_value('co_contact_body', '') , 'class="form-control"')}
      <!-- <textarea class="form-control" id="inputComment" rows="5"></textarea> -->
      {if form_error('co_contact_body')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_body')}</font></label>{/if}
    </div>
  </div>
</section>

  {form_hidden($list)}

  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      {$attr['name'] = 'submit'}
      {$attr['type'] = 'submit'}
      {form_button($attr , '確　　認' , 'class="btn btn-default"')}
    </div>
  </div>

{form_close()}

<!-- </form> -->


<br><br>
<div class="panel panel-default">
  <div class="panel-footer text-center">
    Copyright(C) 2016 - {{$smarty.now|date_format:"%Y"}} Themis Inc. All Rights Reserved.
  </div>
</div>

</body>
</html>
