{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>クライアント情報　　<span class="label label-success">新規登録</span></h3>
</div>

{form_open('entryclient/confirm/' , 'name="EntryadminForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="cl_sales_id" class="col-sm-4 control-label">担当営業選択<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('cl_sales_id', $options_cl_sales_id, set_value('cl_sales_id', ''))}
      {if form_error('cl_sales_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_sales_id')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_editor_id" class="col-sm-4 control-label">担当編集者選択<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('cl_editor_id', $options_cl_editor_id, set_value('cl_editor_id', ''))}
      {if form_error('cl_editor_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_editor_id')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_contract" class="col-sm-4 control-label">契約期間</label>
    <div class="col-sm-4">
      {form_input('cl_contract_str' , set_value('cl_contract_str', '') , 'class="form-control" placeholder="契約開始日(yyyy/dd/mm)を入力してください"')}
      {if form_error('cl_contract_str')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_contract_str')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('cl_contract_end' , set_value('cl_contract_end', '') , 'class="form-control" placeholder="契約終了日(yyyy/dd/mm)を入力してください"')}
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
  <div class="form-group">
    <label for="cl_siteid" class="col-sm-4 control-label">サイトID(URL名)<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_siteid' , set_value('cl_siteid', '') , 'class="form-control" placeholder="サイトID(URL名)を英数字で入力してください。max.20文字"')}
      <p class="redText"><small>※基本後からの変更はできません。お客様と一緒に考えてください。max.20文字。</small></p>
      {if form_error('cl_siteid')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_siteid')}</font></label>{/if}
      {if $err_siteid==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「サイトID(URL名)」欄で入力したIDは既に他で使用されています。再度他のIDを入力してください。</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_id" class="col-sm-4 control-label">仮ログインID<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_id' , set_value('cl_id', '') , 'class="form-control" placeholder="ログインID(英数字、アンダースコア(_)、ダッシュ(-))を入力してください。max.20文字"')}
      {if form_error('cl_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_id')}</font></label>{/if}
      {if $err_clid==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「ログインID」欄で入力したIDは既に他で使用されています。再度他のIDを入力してください。</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_pw" class="col-sm-4 control-label">仮パスワード</label>
    <div class="col-sm-8">
      {form_password('cl_pw' , set_value('cl_pw', '') , 'class="form-control" placeholder="パスワード　(半角英数字・記号：８文字以上)"')}
      <p class="redText"><small>※お客様のお名前や、生年月日、またはその他の個人情報など、推測されやすい情報は使用しないでください</small></p>
      {if form_error('cl_pw')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_pw')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">会社名<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_company' , set_value('cl_company', '') , 'class="form-control" placeholder="会社名を入力してください。max.50文字"')}
      {if form_error('cl_company')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_company')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_president" class="col-sm-4 control-label">代表者(承認メール宛先)<font color=red>【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cl_president01' , set_value('cl_president01', '') , 'class="form-control" placeholder="代表者姓を入力してください。max.50文字"')}
      {if form_error('cl_president01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_president01')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('cl_president02' , set_value('cl_president02', '') , 'class="form-control" placeholder="代表者名を入力してください。max.50文字"')}
      {if form_error('cl_president02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_president02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {form_input('cl_department' , set_value('cl_department', '') , 'class="form-control" placeholder="所属部署を入力してください。max.50文字"')}
      {if form_error('cl_department')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_department')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_person" class="col-sm-4 control-label">担当者<font color=red>【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cl_person01' , set_value('cl_person01', '') , 'class="form-control" placeholder="担当者姓を入力してください。max.50文字"')}
      {if form_error('cl_person01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_person01')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('cl_person02' , set_value('cl_person02', '') , 'class="form-control" placeholder="担当者名を入力してください。max.50文字"')}
      {if form_error('cl_person02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_person02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_tel" class="col-sm-4 control-label">担当者電話番号</label>
    <div class="col-sm-8">
      {form_input('cl_tel' , set_value('cl_tel', '') , 'class="form-control" placeholder="担当者電話番号を入力してください"')}
      {if form_error('cl_tel')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_tel')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mobile" class="col-sm-4 control-label">担当者携帯番号</label>
    <div class="col-sm-8">
      {form_input('cl_mobile' , set_value('cl_mobile', '') , 'class="form-control" placeholder="担当者携帯番号を入力してください"')}
      {if form_error('cl_mobile')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mobile')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_fax" class="col-sm-4 control-label">FAX番号</label>
    <div class="col-sm-8">
      {form_input('cl_fax' , set_value('cl_fax', '') , 'class="form-control" placeholder="FAX番号を入力してください"')}
      {if form_error('cl_fax')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_fax')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mail" class="col-sm-4 control-label">メールアドレス(承認メール送信先)<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_mail' , set_value('cl_mail', '') , 'class="col-sm-4 form-control" placeholder="メールアドレスを入力してください。max.100文字"')}
      {if form_error('cl_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mail')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mailsub" class="col-sm-4 control-label">メールアドレス(サブ)</label>
    <div class="col-sm-8">
      {form_input('cl_mailsub' , set_value('cl_mailsub', '') , 'class="col-sm-4 form-control" placeholder="メールアドレスを入力してください。max.100文字"')}
      {if form_error('cl_mailsub')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mailsub')}</font></label>{/if}
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      {$attr['name'] = 'submit'}
      {$attr['type'] = 'submit'}
      {form_button($attr , '確　　認' , 'class="btn btn-default"')}
    </div>
  </div>

{form_close()}

<!-- </form> -->


{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
