{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>管理者アカウント情報　　<span class="label label-success">新規登録</span></h3>
</div>

{form_open('contact/complete/' , 'name="ConmpForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">名　前</label>
    <div class="col-sm-10">
      {set_value('inputName', '')}
      {form_hidden('inputName', set_value('inputName', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">メールアドレス</label>
    <div class="col-sm-10">
      {set_value('inputEmail', '')}
      {form_hidden('inputEmail', set_value('inputEmail', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="inputTel" class="col-sm-2 control-label">連絡先</label>
    <div class="col-sm-10">
      {set_value('inputTel', '')}
      {form_hidden('inputTel', set_value('inputTel', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="inputComment" class="col-sm-2 control-label">お問合せ内容</label>
    <div class="col-sm-10">
      {set_value('inputComment', '')}
      {form_hidden('inputComment', set_value('inputComment', ''))}
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      {$attr01['name'] = '_back'}
      {$attr01['type'] = 'submit'}
      {$attr01['value'] = '_back'}
      {form_button($attr01 , '戻　　る' , 'class="btn btn-default"')}

      {$attr02['name'] = 'submit'}
      {$attr02['type'] = 'submit'}
      {form_button($attr02 , '問 合 せ' , 'class="btn btn-default"')}
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
