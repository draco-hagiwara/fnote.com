{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>管理者　ログイン画面　　<span class="label label-info">事業者</span></h3>
</div>

{form_open('/login/admincheck/' , 'name="LoginForm" class="form-horizontal"')}


  <div class="form-group">
    <div class=" col-sm-offset-1 col-sm-6 col-sm-offset-5">
      {if $err_mess !=''}<span class="label label-danger">Error : </span><label><font color=red>{$err_mess}</font></label>{/if}
    </div>
    <div class=" col-sm-offset-1 col-sm-6 col-sm-offset-5">
      <label for="cl_siteid">サイトID</label>
      {form_input('cl_siteid' , set_value('cl_siteid', '') , 'class="form-control" placeholder="サイトIDを入力してください。"')}
      {if form_error('cl_siteid')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_siteid')}</font></label>{/if}
    </div>
  </div>
  <br><br>
  <div class="form-group">
    <div class=" col-sm-offset-1 col-sm-6 col-sm-offset-5">
      <label for="ac_id">ADMIN : ログインID</label>
      {form_input('ac_id' , set_value('ac_id', '') , 'class="form-control" placeholder="ログインIDを入力してください。"')}
      {if form_error('ac_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_id')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <div class=" col-sm-offset-1 col-sm-6 col-sm-offset-5">
      <label for="ac_pw">ADMIN : パスワード</label>
      {form_password('ac_pw' , '' , 'class="form-control" placeholder="パスワードを入力してください。"')}
      {if form_error('ac_pw')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_pw')}</font></label>{/if}
    </div>
  </div>

  <br><br>
  <div class="form-group">
    <div class=" col-sm-offset-1 col-sm-6 col-sm-offset-5">
      {$attr['name'] = 'submit'}
      {$attr['type'] = 'submit'}
      {form_button($attr , 'ログイン' , 'class="btn btn-default"')}
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
