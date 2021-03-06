{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>管理者アカウント情報　　<span class="label label-success">新規登録</span></h3>
</div>

{form_open('entryadmin/complete/' , 'name="ConfirmForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="ac_type" class="col-sm-4 control-label">管理種類選択</label>
    <div class="col-sm-8">
      {$account_type}
      {form_hidden('ac_type', set_value('ac_type', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {set_value('ac_department', '')}
      {form_hidden('ac_department', set_value('ac_department', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_person" class="col-sm-4 control-label">担当者</label>
    <div class="col-sm-8">
      {set_value('ac_name01', '')}　
      {form_hidden('ac_name01', set_value('ac_name01', ''))}
      {set_value('ac_name02', '')}
      {form_hidden('ac_name02', set_value('ac_name02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_email" class="col-sm-4 control-label">メールアドレス<br>＆　ログインID</label>
    <div class="col-sm-8">
      {set_value('ac_id', '')}
      {form_hidden('ac_id', set_value('ac_id', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_tel" class="col-sm-4 control-label">担当者電話番号</label>
    <div class="col-sm-8">
      {set_value('ac_tel', '')}
      {form_hidden('ac_tel', set_value('ac_tel', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_mobile" class="col-sm-4 control-label">担当者携帯番号</label>
    <div class="col-sm-8">
      {set_value('ac_mobile', '')}
      {form_hidden('ac_mobile', set_value('ac_mobile', ''))}
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

  {form_hidden('ac_mail', set_value('ac_id', ''))}
  {form_hidden('ac_pw', set_value('ac_pw', ''))}
  {form_hidden('retype_password', set_value('retype_password', ''))}

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
