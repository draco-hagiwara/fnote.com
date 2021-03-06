{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>アカウント情報　　<span class="label label-success">新規登録</span></h3>
</div>

{form_open('entryadmin/confirm/' , 'name="EntryadminForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="ac_type" class="col-sm-4 control-label">管理種類選択<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('ac_type', $options_ac_type, set_value('ac_type', ''))}
      {if form_error('ac_type')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_type')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {form_input('ac_department' , set_value('ac_department', '') , 'class="form-control" placeholder="所属部署を入力してください。max.50文字"')}
      {if form_error('ac_department')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_department')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_name" class="col-sm-4 control-label">担当者<font color=red>【必須】</font></label>
    <div class="col-sm-4">
      {form_input('ac_name01' , set_value('ac_name01', '') , 'class="form-control" placeholder="担当者姓を入力してください。max.50文字"')}
      {if form_error('ac_name01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_name01')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('ac_name02' , set_value('ac_name02', '') , 'class="form-control" placeholder="担当者名を入力してください。max.50文字"')}
      {if form_error('ac_name02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_name02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_id" class="col-sm-4 control-label">メールアドレス<br>＆　ログインID<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('ac_id' , set_value('ac_id', '') , 'class="col-sm-4 form-control" placeholder="メールアドレスを入力してください。max.100文字"')}
      {if form_error('ac_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_id')}</font></label>{/if}
      {if $err_email==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「メールアドレス」欄で入力したアドレスは既に他で使用されています。再度他のアドレスを入力してください。</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_pw" class="col-sm-4 control-label">仮パスワード<font color=red>【必須】</font></label>
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
  <div class="form-group">
    <label for="ac_tel" class="col-sm-4 control-label">担当者電話番号</label>
    <div class="col-sm-8">
      {form_input('ac_tel' , set_value('ac_tel', '') , 'class="form-control" placeholder="担当者電話番号を入力してください"')}
      {if form_error('ac_tel')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_tel')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="ac_mobile" class="col-sm-4 control-label">担当者携帯番号</label>
    <div class="col-sm-8">
      {form_input('ac_mobile' , set_value('ac_mobile', '') , 'class="form-control" placeholder="担当者携帯番号を入力してください"')}
      {if form_error('ac_mobile')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_mobile')}</font></label>{/if}
    </div>
  </div>

  {form_hidden('ac_mail', set_value('ac_id', ''))}

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
