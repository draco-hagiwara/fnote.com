{* ヘッダー部分　START *}
    {include file="../header_entry.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>アカウント情報　　<span class="label label-success">新規登録</span></h3>
</div>




{form_open('entryconf/confirm/' , 'name="EntryconfForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="ac_type" class="col-sm-4 control-label">管理種類選択</label>
    <div class="col-sm-2 btn-lg">
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
    <label for="ac_name" class="col-sm-4 control-label">担当者</label>
    <div class="col-sm-8">
      {$ac_name01}　{$ac_name02}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_id" class="col-sm-4 control-label">メールアドレス<br>＆　ログインID</label>
    <div class="col-sm-8">
      {$ac_id}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_pw" class="col-sm-4 control-label">パスワード<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_password('ac_pw' , set_value('ac_pw', '') , 'class="form-control" placeholder="パスワード　(半角英数字・記号：８文字以上)。max.50文字"')}
      <p class="redText"><small>※お客様のお名前や、生年月日、またはその他の個人情報など、推測されやすい情報は使用しないでください</small></p>
      {if form_error('ac_pw')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_pw')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="retype_password" class="col-sm-4 control-label">パスワード再入力<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_password('retype_password' , set_value('retype_password', '') , 'class="form-control" placeholder="パスワード再入力　(半角英数字・記号：８文字以上)"')}
      <p><small>確認のため、もう一度入力してください。</small></p>
      {if form_error('retype_password')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('retype_password')}</font></label>{/if}
      {if $err_passwd==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「パスワード」欄で入力した文字と違います。再度入力してください。</font></label>{/if}
    </div>
  </div>

  {form_hidden('ac_seq',  $ac_seq)}
  {form_hidden('ac_type', $ac_type)}
  {form_hidden('ticket', $ticket)}

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

{*include file="../footer.tpl"*}
{* フッター部分　END *}

</body>
</html>
