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

</head>

<small>グリッド&レスポンシブ対応</small>
<div>
  <section class="container">
  <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
  <div class="row">

  </div>

<body>

<H3><p class="bg-info">お店（クライアント）情報 プレビュー表示</p></H3>

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
	</div>{$list.en_google_map}
	{if $list.en_google_map}<div id="gmap" style="width : 500px; height : 500px;"></div>{$list.en_google_map}{/if}
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


<form class="form-horizontal" name="preForm" method="post" autocomplete="off" action="/client/top/preview/">

  <input type="hidden" name="cl_seq" value={$list.en_cl_seq}>
  <input type="hidden" name="cl_id" value={$list.en_cl_id}>

{if $list.cl_status == 6}

  <div class="form-group">
    <label for="cl_comment" class="col-sm-3 control-label">承認 & 非承認 事由</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="cl_comment" name="cl_comment" placeholder="承認または非承認の理由を入力してください。max.500文字"></textarea>
    </div>
  </div>

  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-9 col-sm-offset-3">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">承　認</button>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">非承認</button>
  </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">サイト 承認</h4>
        </div>
        <div class="modal-body">
          <p>御社承認が終了し、サイト掲載への最終確認作業を行います。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='client_ok' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal fade" id="myModal02" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">サイト 非承認</h4>
        </div>
        <div class="modal-body">
          <p>承認せず、編集作業へステータスを戻します。&hellip;</p>
          <p>非承認の理由につきまして記入をお願いします。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='client_ng' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
{/if}

</form>
<!-- </form> -->

</section>

<br><br>
<div class="panel panel-default">
  <div class="panel-footer text-center">
    Copyright(C) 2016 - {{$smarty.now|date_format:"%Y"}} Themis Inc. All Rights Reserved.
  </div>
</div>

</body>
</html>
