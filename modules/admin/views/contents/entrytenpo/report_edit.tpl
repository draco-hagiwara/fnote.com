{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<H3><p class="bg-info">店舗記事（クライアント）情報設定</p></H3>


{form_open('entrytenpo/tenpo_pre/' , 'name="EntrytenpoForm" class="form-horizontal"  target="_blank"')}

  {form_hidden($list)}
  {*form_hidden('list', set_value('list', $list))*}

  <div class="form-group">
    <div class="col-sm-offset-10 col-sm-2">
      <button type='submit' name='submit' value='preview' class="btn btn-sm btn-primary">プレビュー</button>
    </div>
  </div>

</form>

{form_open('entrytenpo/report_conf/' , 'name="EntrytenpoForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="en_title01" class="col-sm-3 control-label">	タイトル<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('en_title01' , set_value('en_title01', $list.en_title01) , 'class="form-control" placeholder="タイトルを入力してください。max.100文字"')}
      {if form_error('en_title01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_title01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_body01" class="col-sm-3 control-label">記事本文<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" rows="10" id="en_body01" name="en_body01" placeholder="記事本文を入力してください。max.65,535文字">{$list.en_body01}</textarea>
      {if form_error('en_body01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_body01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_title02" class="col-sm-3 control-label">	タイトルサブ</label>
    <div class="col-sm-9">
      {form_input('en_title02' , set_value('en_title02', $list.en_title02) , 'class="form-control" placeholder="タイトルサブを入力してください"')}
      {if form_error('en_title02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_title02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_body02" class="col-sm-3 control-label">記事本文サブ</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_body02" name="en_body02" placeholder="記事本文サブを入力してください。max.65,535文字">{$list.en_body02}</textarea>
      {if form_error('en_body02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_body02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_entry_tags" class="col-sm-3 control-label">タグ</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_entry_tags" name="en_entry_tags" placeholder="タグを入力してください。max.255文字">{$list.en_entry_tags}</textarea>
      {if form_error('en_entry_tags')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_entry_tags')}</font></label>{/if}
    </div>
  </div>





  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">登録する</button>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">営業 確認</button>
  </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">店舗記事情報　登録</h4>
        </div>
        <div class="modal-body">
          <p>登録しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='save' class="btn btn-sm btn-primary">O  K</button>
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
          <h4 class="modal-title">営業 確認</h4>
        </div>
        <div class="modal-body">
          <p>編集が終了し、営業への確認＆承認依頼を行います。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='salse' class="btn btn-sm btn-primary">O  K</button>
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
