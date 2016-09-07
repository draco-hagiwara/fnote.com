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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDrmCOpsdAhrxRTHwHz9dnGGR-Ug73SzrA"></script>
{*<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>*}

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
	  {$list.iv_title01}
	</div>
	<div class="form-group">
	  {$list.iv_body01}
	</div>
	<div class="form-group">
	  {$list.iv_title02}
	</div>
	<div class="form-group">
	  {$list.iv_body02}
	</div>


<br><br>
<form class="form-horizontal" name="preForm" method="post" autocomplete="off" action="/client/top/preview/">

  <input type="hidden" name="cl_seq" value={$list.iv_cl_seq}>

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


{*
<script type="text/javascript">
  google.maps.event.addDomListener(window, 'load', function() {
      var map = document.getElementById("gmap");
     var options = {
            zoom: 16,
          center: new google.maps.LatLng(35.657062, 139.696105),
          mapTypeId: google.maps.MapTypeId.ROADMAP
       };
     new google.maps.Map(map, options);
 });
</script>
*}


<br><br>
<div class="panel panel-default">
  <div class="panel-footer text-center">
    Copyright(C) 2016 - {{$smarty.now|date_format:"%Y"}} Themis Inc. All Rights Reserved.
  </div>
</div>

</body>
</html>
