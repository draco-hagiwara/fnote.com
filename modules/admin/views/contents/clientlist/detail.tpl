{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>クライアント情報　　<span class="label label-success">更新</span></h3>
</div>

{form_open('/clientlist/detailchk/' , 'name="clientDetailForm" class="form-horizontal"')}

  {$mess}
  {if $smarty.session.a_memType==2}
  <div class="form-group">
    <label for="cl_status" class="col-sm-4 control-label">ステータス選択<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('cl_status', $options_cl_status, set_value('cl_status', $info.cl_status))}
      {if form_error('cl_status')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_status')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_sales_id" class="col-sm-4 control-label">担当営業選択<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('cl_sales_id', $options_cl_sales_id, $select_salesno)}
    </div>
    <div class="col-sm-4">
      {if form_error('cl_sales_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_sales_id')}</font></label>{/if}
      {if $select_salesno===""}<span class="label label-danger">Error : </span><label><font color=red>該当する担当営業({$salse_name})が存在しません。</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_editor_id" class="col-sm-4 control-label">担当編集者選択<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('cl_editor_id', $options_cl_editor_id, $select_editorno)}
    </div>
    <div class="col-sm-4">
      {if form_error('cl_editor_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_editor_id')}</font></label>{/if}
      {if $select_editorno===""}<span class="label label-danger">Error : </span><label><font color=red>該当する担当編集者({$editor_name})が存在しません。</font></label>{/if}
    </div>
  </div>
  {else}
    {form_hidden('cl_status', $info.cl_status)}
    {form_hidden('cl_sales_id', $select_salesno)}
    {form_hidden('cl_editor_id', $select_editorno)}
  {/if}

  {if $smarty.session.a_memType!=0}
  <div class="form-group">
    <label for="cl_contract" class="col-sm-4 control-label">契約期間</label>
    <div class="col-sm-4">
      {form_input('cl_contract_str' , set_value('cl_contract_str', $info.cl_contract_str) , 'class="form-control" placeholder="契約開始日(yyyy-dd-mm)を入力してください"')}
      {if form_error('cl_contract_str')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_contract_str')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('cl_contract_end' , set_value('cl_contract_end', $info.cl_contract_end) , 'class="form-control" placeholder="契約終了日(yyyy-dd-mm)を入力してください"')}
      {if form_error('cl_contract_end')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_contract_end')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_plan" class="col-sm-4 control-label">利用プラン</label>
    <div class="col-sm-8">
      {form_input('cl_plan' , set_value('cl_plan', 'BASICプラン') , 'class="form-control" placeholder="ご利用プランを入力してください"')}
      {if form_error('cl_plan')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_plan')}</font></label>{/if}
    </div>
  </div>
  {if $smarty.session.a_memSeq==1}
  <div class="form-group">
    <label for="cl_siteid" class="col-sm-4 control-label">サイトID(URL名)<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_siteid' , set_value('cl_siteid', $info.cl_siteid) , 'class="form-control" placeholder="サイトID(URL名)を英数字で入力してください"')}
      <p class="redText"><small>※できるだけお客様と一緒に考えてください。max.20文字。基本変更不可です。</small></p>
      {if form_error('cl_siteid')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_siteid')}</font></label>{/if}
      {if $err_siteid==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「サイトID(URL名)」欄で入力したIDは既に他で使用されています。再度他のIDを入力してください。</font></label>{/if}
    </div>
  </div>
  {else}
  <div class="form-group">
    <label for="cl_siteid" class="col-sm-4 control-label">サイトID(URL名)<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {$info.cl_siteid}
      {form_hidden('cl_siteid', $info.cl_siteid)}
    </div>
  </div>
  {/if}
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">会社名<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_company' , set_value('cl_company', $info.cl_company) , 'class="form-control" placeholder="会社名を入力してください"')}
      {if form_error('cl_company')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_company')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_president" class="col-sm-4 control-label">代表者(承認メール宛先)<font color=red>【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cl_president01' , set_value('cl_president01', $info.cl_president01) , 'class="form-control" placeholder="代表者姓を入力してください"')}
      {if form_error('cl_president01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_president01')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('cl_president02' , set_value('cl_president02', $info.cl_president02) , 'class="form-control" placeholder="代表者名を入力してください"')}
      {if form_error('cl_president02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_president02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {form_input('cl_department' , set_value('cl_department', $info.cl_department) , 'class="form-control" placeholder="所属部署を入力してください"')}
      {if form_error('cl_department')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_department')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_person" class="col-sm-4 control-label">担当者<font color=red>【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cl_person01' , set_value('cl_person01', $info.cl_person01) , 'class="form-control" placeholder="担当者姓を入力してください"')}
      {if form_error('cl_person01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_person01')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('cl_person02' , set_value('cl_person02', $info.cl_person02) , 'class="form-control" placeholder="担当者名を入力してください"')}
      {if form_error('cl_person02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_person02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_tel" class="col-sm-4 control-label">担当者電話番号<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_tel' , set_value('cl_tel', $info.cl_tel) , 'class="form-control" placeholder="担当者電話番号を入力してください"')}
      {if form_error('cl_tel')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_tel')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mobile" class="col-sm-4 control-label">担当者携帯番号</label>
    <div class="col-sm-8">
      {form_input('cl_mobile' , set_value('cl_mobile', $info.cl_mobile) , 'class="form-control" placeholder="担当者携帯番号を入力してください"')}
      {if form_error('cl_mobile')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mobile')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_fax" class="col-sm-4 control-label">FAX番号</label>
    <div class="col-sm-8">
      {form_input('cl_fax' , set_value('cl_fax', $info.cl_fax) , 'class="form-control" placeholder="FAX番号を入力してください"')}
      {if form_error('cl_fax')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_fax')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mail" class="col-sm-4 control-label">メールアドレス(承認メール送信先)<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_mail' , set_value('cl_mail', $info.cl_mail) , 'class="col-sm-4 form-control" placeholder="メールアドレスを入力してください"')}
      {if form_error('cl_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mail')}</font></label>{/if}
      {if $err_mail==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「メールアドレス」欄で入力したアドレスは既に他で使用されています。再度他のアドレスを入力してください。</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mailsub" class="col-sm-4 control-label">メールアドレス(サブ)</label>
    <div class="col-sm-8">
      {form_input('cl_mailsub' , set_value('cl_mailsub', $info.cl_mailsub) , 'class="col-sm-4 form-control" placeholder="メールアドレスを入力してください"')}
      {if form_error('cl_mailsub')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mailsub')}</font></label>{/if}
    </div>
  </div>

  {form_hidden('cl_seq', $info.cl_seq)}
  {form_hidden('cl_id', $info.cl_id)}

  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">更新する</button>
    {if $info.cl_status==0}<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">メール再発行</button>{/if}
  </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">クライアント情報　更新</h4>
        </div>
        <div class="modal-body">
          <p>更新しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='submit' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">クライアント情報　メール再発行</h4>
        </div>
        <div class="modal-body">
          <p>メールを再発行しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='re_mail' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

{/if}

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
