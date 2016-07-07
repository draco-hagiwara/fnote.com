{* ヘッダー部分　START *}
    {include file="../header_entry.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>管理者アカウント情報　　<span class="label label-success">新規登録</span></h3>
</div>

{form_open('entryconf/cl_complete/' , 'name="ConfirmForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="cl_siteid" class="col-sm-4 control-label">サイトID(URL名)</label>
    <div class="col-sm-8">
      {$cl_siteid}
      {form_hidden('cl_siteid', $cl_siteid)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_id" class="col-sm-4 control-label">ログインID</label>
    <div class="col-sm-8">
      {$cl_id}
      {form_hidden('cl_id', $cl_id)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">会社名</label>
    <div class="col-sm-8">
      {$cl_company}
      {form_hidden('cl_company', $cl_company)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_president" class="col-sm-4 control-label">代表者(承認メール宛先)</label>
    <div class="col-sm-8">
      {$cl_president01}　{$cl_president02}
      {form_hidden('cl_president01', $cl_president01)}
      {form_hidden('cl_president02', $cl_president02)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {$cl_department}
      {form_hidden('cl_department', $cl_department)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_person" class="col-sm-4 control-label">担当者</label>
    <div class="col-sm-8">
      {$cl_person01}　{$cl_person02}
      {form_hidden('cl_person01', $cl_person01)}
      {form_hidden('cl_person02', $cl_person02)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_tel" class="col-sm-4 control-label">担当者電話番号</label>
    <div class="col-sm-8">
      {$cl_tel}
      {form_hidden('cl_tel', $cl_tel)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mobile" class="col-sm-4 control-label">担当者携帯番号</label>
    <div class="col-sm-8">
      {$cl_mobile}
      {form_hidden('cl_mobile', $cl_mobile)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_fax" class="col-sm-4 control-label">FAX番号</label>
    <div class="col-sm-8">
      {$cl_fax}
      {form_hidden('cl_fax', $cl_fax)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mail" class="col-sm-4 control-label">メールアドレス(承認メール送信先)</label>
    <div class="col-sm-8">
      {$cl_mail}
      {form_hidden('cl_mail', $cl_mail)}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mailsub" class="col-sm-4 control-label">メールアドレス(サブ)</label>
    <div class="col-sm-8">
      {$cl_mailsub}
      {form_hidden('cl_mailsub', $cl_mailsub)}
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
      {form_button($attr02 , '登　録　&　承　認' , 'class="btn btn-default"')}
    </div>
  </div>

  {form_hidden('cl_seq', $cl_seq)}
  {form_hidden('cl_pw', $cl_pw)}
  {form_hidden('retype_password',  $retype_password)}
  {form_hidden('ticket', $ticket)}

{form_close()}



{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{*include file="../footer.tpl"*}
{* フッター部分　END *}

</body>
</html>
