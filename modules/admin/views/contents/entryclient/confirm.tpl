{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>クライアント情報　　<span class="label label-success">新規登録</span></h3>
</div>

{form_open('entryclient/complete/' , 'name="ConfirmForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="cl_sales_id" class="col-sm-4 control-label">担当営業選択</label>
    <div class="col-sm-8">
      {$options_cl_sales_id}
      {form_hidden('cl_sales_id', set_value('cl_sales_id', '0'))}
      {form_hidden('_sales_id', set_value('_sales_id', $options_cl_sales_id))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_editor_id" class="col-sm-4 control-label">担当編集者選択</label>
    <div class="col-sm-8">
      {$options_cl_editor_id}
      {form_hidden('cl_editor_id', set_value('cl_editor_id', '0'))}
      {form_hidden('_editor_id', set_value('_editor_id', $options_cl_editor_id))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_contract" class="col-sm-4 control-label">契約期間</label>
    <div class="col-sm-8">
      {set_value('cl_contract_str', '')}　
      {form_hidden('cl_contract_str', set_value('cl_contract_str', ''))}
      {set_value('cl_contract_end', '')}
      {form_hidden('cl_contract_end', set_value('cl_contract_end', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_siteid" class="col-sm-4 control-label">仮サイトID(URL名)</label>
    <div class="col-sm-8">
      {set_value('cl_siteid', '')}
      {form_hidden('cl_siteid', set_value('cl_siteid', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_id" class="col-sm-4 control-label">仮ログインID</label>
    <div class="col-sm-8">
      {set_value('cl_id', '')}
      {form_hidden('cl_id', set_value('cl_id', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_pw" class="col-sm-4 control-label">仮パスワード</label>
    <div class="col-sm-8">
      {set_value('cl_pw', '')}
      {form_hidden('cl_pw', set_value('cl_pw', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">会社名</label>
    <div class="col-sm-8">
      {set_value('cl_company', '')}
      {form_hidden('cl_company', set_value('cl_company', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_president" class="col-sm-4 control-label">代表者</label>
    <div class="col-sm-8">
      {set_value('cl_president01', '')}　
      {form_hidden('cl_president01', set_value('cl_president01', ''))}
      {set_value('cl_president02', '')}
      {form_hidden('cl_president02', set_value('cl_president02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {set_value('cl_department', '')}
      {form_hidden('cl_department', set_value('cl_department', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_person" class="col-sm-4 control-label">担当者</label>
    <div class="col-sm-8">
      {set_value('cl_person01', '')}　
      {form_hidden('cl_person01', set_value('cl_person01', ''))}
      {set_value('cl_person02', '')}
      {form_hidden('cl_person02', set_value('cl_person02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_tel" class="col-sm-4 control-label">担当者電話番号</label>
    <div class="col-sm-8">
      {set_value('cl_tel', '')}
      {form_hidden('cl_tel', set_value('cl_tel', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mobile" class="col-sm-4 control-label">担当者携帯番号</label>
    <div class="col-sm-8">
      {set_value('cl_mobile', '')}
      {form_hidden('cl_mobile', set_value('cl_mobile', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_fax" class="col-sm-4 control-label">FAX番号</label>
    <div class="col-sm-8">
      {set_value('cl_fax', '')}
      {form_hidden('cl_fax', set_value('cl_fax', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mail" class="col-sm-4 control-label">メールアドレス</label>
    <div class="col-sm-8">
      {set_value('cl_mail', '')}
      {form_hidden('cl_mail', set_value('cl_mail', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mailsub" class="col-sm-4 control-label">メールアドレス(サブ)</label>
    <div class="col-sm-8">
      {set_value('cl_mailsub', '')}
      {form_hidden('cl_mailsub', set_value('cl_mailsub', ''))}
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      {$attr01['name'] = '_back'}
      {$attr01['type'] = 'submit'}
      {$attr01['value'] = '_back'}
      {form_button($attr01 , '戻　　る' , 'class="btn btn-default"')}

      {$attr02['name'] = 'submit'}
      {$attr02['type'] = 'submit'}
      {form_button($attr02 , '登　　録' , 'class="btn btn-default"')}
    </div>
  </div>

{form_close()}



{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
