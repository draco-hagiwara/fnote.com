{* ヘッダー部分　START *}
    {include file="../header_entry.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>お客様情報　　<span class="label label-success">新規登録</span></h3>
</div>




{form_open('entryconf/cl_confirm/' , 'name="EntryconfForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="cl_siteid" class="col-sm-4 control-label">サイトID(URL名)<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {$cl_siteid}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_id" class="col-sm-4 control-label">ログインID<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_id' , set_value('cl_id', $cl_id) , 'class="form-control" placeholder="ログインID(英数字、アンダースコア("_")、ダッシュ("-"))を入力してください。max.20文字"')}
      {if form_error('cl_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_id')}</font></label>{/if}
      {if $err_clid==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「ログインID」欄で入力したIDは既に他で使用されています。再度他のIDを入力してください。</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_pw" class="col-sm-4 control-label">パスワード<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_password('cl_pw' , set_value('cl_pw', '') , 'class="form-control" placeholder="パスワード　(半角英数字・記号：８文字以上)。max.50文字"')}
      <p class="redText"><small>※お客様のお名前や、生年月日、またはその他の個人情報など、推測されやすい情報は使用しないでください</small></p>
      {if form_error('cl_pw')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_pw')}</font></label>{/if}
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
    <label for="cl_company" class="col-sm-4 control-label">会社名<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_company' , set_value('cl_company', $cl_company) , 'class="form-control" placeholder="会社名を入力してください。max.50文字"')}
      {if form_error('cl_company')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_company')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_president" class="col-sm-4 control-label">代表者(承認メール宛先)<font color=red>【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cl_president01' , set_value('cl_president01', $cl_president01) , 'class="form-control" placeholder="代表者姓を入力してください。max.50文字"')}
      {if form_error('cl_president01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_president01')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('cl_president02' , set_value('cl_president02', $cl_president02) , 'class="form-control" placeholder="代表者名を入力してください。max.50文字"')}
      {if form_error('cl_president02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_president02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {form_input('cl_department' , set_value('cl_department', $cl_department) , 'class="form-control" placeholder="所属部署を入力してください。max.50文字"')}
      {if form_error('cl_department')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_department')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_person" class="col-sm-4 control-label">担当者<font color=red>【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cl_person01' , set_value('cl_person01', $cl_person01) , 'class="form-control" placeholder="担当者姓を入力してください。max.50文字"')}
      {if form_error('cl_person01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_person01')}</font></label>{/if}
    </div>
    <div class="col-sm-4">
      {form_input('cl_person02' , set_value('cl_person02', $cl_person02) , 'class="form-control" placeholder="担当者名を入力してください。max.50文字"')}
      {if form_error('cl_person02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_person02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_tel" class="col-sm-4 control-label">担当者電話番号<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_tel' , set_value('cl_tel', $cl_tel) , 'class="form-control" placeholder="担当者電話番号を入力してください"')}
      {if form_error('cl_tel')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_tel')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mobile" class="col-sm-4 control-label">担当者携帯番号</label>
    <div class="col-sm-8">
      {form_input('cl_mobile' , set_value('cl_mobile', $cl_mobile) , 'class="form-control" placeholder="担当者携帯番号を入力してください"')}
      {if form_error('cl_mobile')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mobile')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_fax" class="col-sm-4 control-label">FAX番号</label>
    <div class="col-sm-8">
      {form_input('cl_fax' , set_value('cl_fax', $cl_fax) , 'class="form-control" placeholder="FAX番号を入力してください"')}
      {if form_error('cl_fax')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_fax')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mail" class="col-sm-4 control-label">メールアドレス(承認メール送信先)<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('cl_mail' , set_value('cl_mail', $cl_mail) , 'class="col-sm-4 form-control" placeholder="メールアドレスを入力してください。max.100文字"')}
      {if form_error('cl_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mail')}</font></label>{/if}
      {if $err_mail==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「メールアドレス」欄で入力したアドレスは既に他で使用されています。再度他のアドレスを入力してください。</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mailsub" class="col-sm-4 control-label">メールアドレス(サブ)</label>
    <div class="col-sm-8">
      {form_input('cl_mailsub' , set_value('cl_mailsub', $cl_mailsub) , 'class="col-sm-4 form-control" placeholder="メールアドレスを入力してください。max.100文字"')}
      {if form_error('cl_mailsub')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_mailsub')}</font></label>{/if}
    </div>
  </div>
  <br><br>
  <div class="form-group">
    <div class="col-sm-offset-5 col-sm-7">
      {form_checkbox('checkKiyaku[]','1',set_checkbox('checkKiyaku[]', '1'))}規約に同意します。
      {if $err_checkKiyaku==TRUE}<p><span class="label label-danger">Error : </span><label><font color=red>「規約に同意」にチェックを入れてください。</font></label><p>{/if}
    </div>
  </div>

  {form_hidden('cl_seq',    $cl_seq)}
  {form_hidden('cl_siteid', $cl_siteid)}
  {form_hidden('ticket',    $ticket)}

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
