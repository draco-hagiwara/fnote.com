{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<p class="bg-info">　■　登録・編集</p>

<!-- <form> -->
{form_open('tenpo_coupon/comp/' , 'name="detailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="cp_template" class="col-sm-2 control-label">デザインテンプレート選択</label>
    <div class="col-sm-2">
      {form_dropdown('cp_template', $options_tpl, $list.cp_template)}
    </div>
  </div>

  <div class="form-group">
    <label for="cp_title" class="col-sm-2 control-label">タイトル</label>
    <div class="col-sm-4">
      {form_input('cp_title' , set_value('cp_title', $list.cp_title) , 'class="form-control" placeholder="タイトルを入力してください。max.20文字"')}
      {if form_error('cp_title')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_title')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_content" class="col-sm-2 control-label">クーポンの内容</label>
    <div class="col-sm-10">
      {form_input('cp_content' , set_value('cp_content', $list.cp_content) , 'class="form-control" placeholder="クーポン内容を入力してください。max.80文字"')}
      {if form_error('cp_content')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_content')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_use" class="col-sm-2 control-label">利用条件</label>
    <div class="col-sm-10">
      {form_input('cp_use' , set_value('cp_use', $list.cp_use) , 'class="form-control" placeholder="利用条件を入力してください。max.120文字"')}
      {if form_error('cp_use')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_use')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_presen" class="col-sm-2 control-label">提示条件</label>
    <div class="col-sm-10">
      {form_input('cp_presen' , set_value('cp_presen', $list.cp_presen) , 'class="form-control" placeholder="提示条件を入力してください。max.80文字"')}
      {if form_error('cp_presen')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_presen')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_memo" class="col-sm-2 control-label">備　考</label>
    <div class="col-sm-10">
      {form_input('cp_memo' , set_value('cp_memo', $list.cp_memo) , 'class="form-control" placeholder="備考を入力してください。max.80文字"')}
      {if form_error('cp_memo')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_memo')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cp_start_date" class="col-sm-2 control-label">有効期間</label>
    <div class="col-sm-2">
      {form_input('cp_start_date' , set_value('cp_start_date', $list.cp_start_date) , 'class="form-control" placeholder="開始日を入力してください。"')}
      {if form_error('cp_start_date')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_start_date')}</font></label>{/if}
    </div>
    <div class="col-sm-1">～</div>
    <div class="col-sm-2">
      {form_input('cp_end_date' , set_value('cp_end_date', $list.cp_end_date) , 'class="form-control" placeholder="終了日を入力してください。"')}
      {if form_error('cp_end_date')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cp_end_date')}</font></label>{/if}
    </div>
  </div>

  <div class="radio">
    <label for="cp_start_date" class="col-sm-2 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios02" id="optionsRadios1" value="0" {if $list.cp_update==0}checked{/if}>更新する（1ヶ月延長）　　
    </label>
    <label>
      <input type="radio" name="optionsRadios02" id="optionsRadios2" value="1" {if $list.cp_update==1}checked{/if}>更新しない
    </label>
    <label>※更新は、有効期間終了日当日のみ有効です。</label>
  </div>
  <br>
  <div class="radio">
    <label class="col-sm-2 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios1" value="0" {if $list.cp_status==0}checked{/if}>公開する　　
    </label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios2" value="1" {if $list.cp_status==1}checked{/if}>非公開にする
    </label>
  </div>

  <br><br>
  <div class="form-group">
    <label for="cp_start_date" class="col-sm-2 control-label">【表示イメージ】</label>
    <div class="col-sm-10">
      <table border="1">
        <tr>
          <td><img src="../../../images/coupon_tpl/{$tpl_img}" width=180 height=80></td>
          <td bgcolor="#dcdcdc">
            　{$list.cp_content}<br>
            　提示条件：{$list.cp_presen}<br>
            　利用条件：{$list.cp_use}<br>
            　使用期限：{$list.cp_start_date}　～　{$list.cp_end_date}
          </td>
        </tr>
      </table>
    </div>
  </div>

  {form_hidden('cp_seq', $list.cp_seq)}

  <br><br>
  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">更新する</button>
  </div>
  <div class="col-sm-2 col-sm-offset-1">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">削除する</button>
  </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">店舗クーポン情報　更新</h4>
        </div>
        <div class="modal-body">
          <p>更新しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='_chg' class="btn btn-sm btn-primary">O  K</button>
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
          <h4 class="modal-title">店舗クーポン情報　削除</h4>
        </div>
        <div class="modal-body">
          <p>削除しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='_del' class="btn btn-sm btn-primary">O  K</button>
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
