{* ヘッダー部分　START *}
    {include file="../header_pre.tpl" head_index="1"}

<body>

<H3><p class="bg-info">お店（クライアント）情報 プレビュー表示</p></H3>

	<div class="form-group">
	  {$interview.iv_title01}
	</div>
	<div class="form-group">
	  {$interview.iv_body01}
	</div>
	<div class="form-group">
	  {$interview.iv_title02}
	</div>
	<div class="form-group">
	  {$interview.iv_body02}
	</div>


<br><br>
<form class='form-horizontal' name='preForm' method='post' autocomplete='off' action='/admin/tenpo_interview/request/'>

  <input type="hidden" name="cl_seq" value={$interview.iv_cl_seq}>

{if $smarty.session.a_memType==1}{if $interview.cl_status == 5}

  <div class="form-group">
    <label for="cl_comment" class="col-sm-3 control-label">承認 & 非承認 事由</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="cl_comment" name="cl_comment" placeholder="承認または非承認の理由を入力してください。max.500文字">{$interview.cl_comment}</textarea>
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

{if $smarty.session.a_memType!=1}{if $interview.cl_status == 7}
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


<br><br>
<div class="panel panel-default">
  <div class="panel-footer text-center">
    Copyright(C) 2016 - {{$smarty.now|date_format:"%Y"}} Themis Inc. All Rights Reserved.
  </div>
</div>

</body>
</html>
