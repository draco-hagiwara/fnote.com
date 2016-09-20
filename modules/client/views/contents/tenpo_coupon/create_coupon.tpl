{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}


<p class="bg-info">　【 店舗クーポン　新規登録 】</p>

<!-- <form> -->
{form_open('tenpo_coupon/create_coupon/' , 'name="createForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="cp_template" class="col-sm-2 control-label">デザインテンプレート選択</label>
    <div class="col-sm-2">
      {form_dropdown('cp_template', $options_tpl)}
    </div>
  </div>

  <div class="form-group">
    <label for="cp_title" class="col-sm-2 control-label">タイトル<font color=red>【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cp_title' , set_value('cp_title', '') , 'class="form-control" placeholder="タイトルを入力してください。max.25文字"')}
      {if form_error('cp_title')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_title')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_content" class="col-sm-2 control-label">クーポンの内容<font color=red>【必須】</font></label>
    <div class="col-sm-10">
      {form_input('cp_content' , set_value('cp_content', '') , 'class="form-control" placeholder="クーポン内容を入力してください。max.80文字"')}
      {if form_error('cp_content')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_content')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_use" class="col-sm-2 control-label">利用条件<font color=red>【必須】</font></label>
    <div class="col-sm-10">
      {form_input('cp_use' , set_value('cp_use', '') , 'class="form-control" placeholder="利用条件を入力してください。max.120文字"')}
      {if form_error('cp_use')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_use')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_presen" class="col-sm-2 control-label">提示条件<font color=red>【必須】</font></label>
    <div class="col-sm-10">
      {form_input('cp_presen' , set_value('cp_presen', '') , 'class="form-control" placeholder="提示条件を入力してください。max.80文字"')}
      {if form_error('cp_presen')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_presen')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_memo" class="col-sm-2 control-label">備　考</label>
    <div class="col-sm-10">
      {form_input('cp_memo' , set_value('cp_memo', '') , 'class="form-control" placeholder="備考を入力してください。max.80文字"')}
      {if form_error('cp_memo')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_memo')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_start_date" class="col-sm-2 control-label">有効期間<font color=red>【必須】</font></label>
    <div class="col-sm-2">
      {form_input('cp_start_date' , set_value('cp_start_date', '') , 'class="form-control" placeholder="開始日(yyyy-mm-dd)"')}
      {if form_error('cp_start_date')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_start_date')}</font></label>{/if}
    </div>
    <div class="col-sm-1">～</div>
    <div class="col-sm-2">
      {form_input('cp_end_date' , set_value('cp_end_date', '') , 'class="form-control" placeholder="終了日(yyyy-mm-dd)"')}
      {if form_error('cp_end_date')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_end_date')}</font></label>{/if}
    </div>
  </div>

  <div class="radio">
    <label for="cp_update" class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
      <label>
        <input type="radio" name="optionsRadios02" id="optionsRadios1" value="0" >更新する（1ヶ月延長）　　
      </label>
      <label>
        <input type="radio" name="optionsRadios02" id="optionsRadios2" value="1" checked>更新しない
      </label>
      <label>※更新は、有効期間終了日当日のみ有効です。</label>
    </div>
  </div>
  <div class="radio">
    <label for="cp_update" class="col-sm-2 control-label"></label>
    <div class="col-sm-6">
      <label>
        <input type="radio" name="optionsRadios01" id="optionsRadios1" value="0" >公開する　　
      </label>
      <label>
        <input type="radio" name="optionsRadios01" id="optionsRadios2" value="1" checked>非公開にする
      </label>
    </div>
  </div>

  <br><br>
  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">登録する</button>
  </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">店舗クーポン情報　新規登録</h4>
        </div>
        <div class="modal-body">
          <p>登録しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='_chg' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


{form_close()}
<!-- </form> -->


<br><br>
{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
