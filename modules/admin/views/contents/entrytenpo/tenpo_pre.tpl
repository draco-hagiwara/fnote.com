{* ヘッダー部分　START *}
    {include file="../header_pre.tpl" head_index="1"}

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
	  {$list.en_cate|escape:"html"}
	</div>
	<div class="form-group">
	  {$list.en_shopname}
	</div>
	<div class="form-group">
	  {$list.en_shopname_sub}
	</div>
	<div class="form-group">
	  {$list.en_url|escape:"html"}
	</div>
	<div class="form-group">
	  {$list.en_zip01} {$list.en_zip02}
	</div>
	<div class="form-group">
	  {$list.en_pref|escape:"html"} {$list.en_addr01|escape:"html"} {$list.en_addr02|escape:"html"} {$list.en_buil|escape:"html"}
	</div>
	<div class="form-group">
	  {$list.en_tel|escape:"html"}
	</div>
	<div class="form-group">
	  {$list.en_mail|escape:"html"}
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
	  {$list.en_sns05}
	</div>
	{if $list.en_google_map}<div id="gmap" style="width : 500px; height : 500px;"></div>{$list.en_google_map}{/if}
	{if $list.en_qrcode_site}<img src='/admin/entrytenpo/qr_site/{$list.en_seq}' />{/if}
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


<form class='form-horizontal' name='preForm' method='post' autocomplete='off' action='/admin/entrytenpo/request/'>

  <input type="hidden" name="cl_seq" value={$list.en_cl_seq}>
  <input type="hidden" name="cl_id" value={$list.en_cl_id}>

{if $smarty.session.a_memType==1}{if $list.cl_status == 5}

  <div class="form-group">
    <label for="cl_comment" class="col-sm-3 control-label">承認 & 非承認 事由</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="cl_comment" name="cl_comment" placeholder="承認または非承認の理由を入力してください。max.500文字">{$list.cl_comment}</textarea>
    </div>
  </div>

  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-9 col-sm-offset-3">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">営業 承認</button>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">営業 非承認</button>
  </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">営業 承認</h4>
        </div>
        <div class="modal-body">
          <p>営業承認が終了し、クライアントへの確認＆承認依頼を行います。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='salse_ok' class="btn btn-sm btn-primary">O  K</button>
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
          <h4 class="modal-title">営業 非承認</h4>
        </div>
        <div class="modal-body">
          <p>承認せず、編集作業へステータスを戻します。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='salse_ng' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
{/if}{/if}

{if $smarty.session.a_memType!=1}{if $list.cl_status == 7}
  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-9 col-sm-offset-3">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal03">最終承認（掲載開始）</button>
  </div>
  </div>

  <div class="modal fade" id="myModal03" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">最終承認（掲載開始）</h4>
        </div>
        <div class="modal-body">
          <p>全ての確認が終了し、掲載をスタートさせます。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='final' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
{/if}{/if}



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
