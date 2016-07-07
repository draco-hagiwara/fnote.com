{* ヘッダー部分　START *}
    {include file="../header_entry.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>管理者アカウント情報　　<span class="label label-success">新規登録</span></h3>
</div>

{form_open('entryconf/complete/' , 'name="ConfirmForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="ac_type" class="col-sm-4 control-label">管理種類選択</label>
    <div class="col-sm-8">
      {$account_type}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {$ac_department}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_person" class="col-sm-4 control-label">担当者</label>
    <div class="col-sm-8">
      {$ac_name01}　{$ac_name02}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_email" class="col-sm-4 control-label">メールアドレス<br>＆　ログインID</label>
    <div class="col-sm-8">
      {$ac_id}
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

  {form_hidden('ac_seq',  $ac_seq)}
  {form_hidden('ac_type', $ac_type)}
  {form_hidden('ac_pw', set_value('ac_pw', ''))}
  {form_hidden('retype_password', set_value('retype_password', ''))}
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
