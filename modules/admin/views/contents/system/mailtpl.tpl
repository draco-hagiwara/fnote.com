{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>メールテンプレート 設定画面　　<span class="label label-danger">システム</span></h3>
</div>

{form_open('/system/tpldetail/' , 'name="mailtplForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="mt_id" class="col-sm-3 control-label">テンプレート選択<font color=red>【必須】</font></label>
    <div class="col-sm-3">
      {form_dropdown('mt_id', $options_tpltitle, {$mailtpl_info.mt_id})}
    </div>
    <div class="col-sm-1">
      {$attr['name']  = 'submit'}
      {$attr['type']  = 'submit'}
      {$attr['value'] = '_select'}
      {form_button($attr , '選　　択' , 'class="btn btn-default"')}
    </div>
  </div>
  <div class="form-group">
    <label for="mt_subject" class="col-sm-3 control-label">メール件名<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('mt_subject' , $mailtpl_info.mt_subject , 'class="form-control" placeholder=""')}
      {if form_error('mt_subject')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mt_subject')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="mt_body" class="col-sm-3 control-label">メール本文<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {$attr02['name']='mt_body'}
      {$attr02['rows']=20}
      {form_textarea($attr02 , set_value('mtbody', $mailtpl_info.mt_body) , 'class="form-control" placeholder=""')}
      {if form_error('mt_body')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mt_body')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="mt_from" class="col-sm-3 control-label">メールfrom<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('mt_from' , $mailtpl_info.mt_from , 'class="form-control" placeholder=""')}
      {if form_error('mt_from')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mt_from')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="mt_from_name" class="col-sm-3 control-label">メールfrom名称<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('mt_from_name' , $mailtpl_info.mt_from_name , 'class="form-control" placeholder=""')}
      {if form_error('mt_from_name')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mt_from_name')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="mt_to" class="col-sm-3 control-label">メールto</label>
    <div class="col-sm-9">
      {form_input('mt_to' , $mailtpl_info.mt_to , 'class="form-control" placeholder=""')}
      {if form_error('mt_to')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mt_to')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="mt_cc" class="col-sm-3 control-label">メールcc</label>
    <div class="col-sm-9">
      {form_input('mt_cc' , $mailtpl_info.mt_cc , 'class="form-control" placeholder=""')}
      {if form_error('mt_cc')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mt_cc')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="mt_bcc" class="col-sm-3 control-label">メールbcc</label>
    <div class="col-sm-9">
      {form_input('mt_bcc' , $mailtpl_info.mt_bcc , 'class="form-control" placeholder=""')}
      {if form_error('mt_bcc')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mt_bcc')}</font></label>{/if}
    </div>
  </div>

  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-4 col-sm-offset-3">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">内容更新</button>
  </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">メールテンプレート情報　更新</h4>
        </div>
        <div class="modal-body">
          <p>更新しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='_submit' class="btn btn-sm btn-primary">O  K</button>
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
