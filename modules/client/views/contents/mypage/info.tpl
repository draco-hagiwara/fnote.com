{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>基本情報 変更画面</h3>
</div>

{form_open('/mypage/info/' , 'name="idpwForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="cl_id" class="col-sm-2 col-sm-offset-1 control-label">ログインID<font color=red>　【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cl_id' , set_value('cl_id', $cl_id) , 'class="col-sm-4 form-control" placeholder="ログインID(英数字、アンダースコア(_)、ダッシュ(-) のみ)を入力してください。max.20文字"')}
      {if form_error('cl_id')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_id')}</font></label>{/if}
      {if $err_clid==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「ログインID」欄で入力した値は既に他で使用されています。再度入力してください。</font></label>{/if}
    </div>
    <button type="button" class="col-sm-1 col-sm-offset-3 btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">更新する</button>
  </div>
  <div class="form-group">
    <label for="cl_pw" class="col-sm-2 col-sm-offset-1 control-label">パスワード<font color=red>　【必須】</font></label>
    <div class="col-sm-4">
      {form_password('cl_pw' , set_value('cl_pw', '') , 'class="form-control" placeholder="パスワード　(半角英数字・記号：８文字以上)。max.50文字"')}
      {if form_error('cl_pw')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_pw')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="retype_password" class="col-sm-2 col-sm-offset-1 control-label">パスワード再入力<font color=red>　【必須】</font></label>
    <div class="col-sm-4">
      {form_password('retype_password' , set_value('retype_password', '') , 'class="form-control" placeholder="パスワード再入力　(半角英数字・記号：８文字以上)"')}
      <p><small>確認のため、もう一度入力してください。</small></p>
      {if form_error('retype_password')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('retype_password')}</font></label>{/if}
      {if $err_passwd==TRUE}<span class="label label-danger">Error : </span><label><font color=red>「パスワード」欄で入力した文字と違います。再度入力してください。</font></label>{/if}
    </div>
  </div>


<br><hr><br>


  <div class="form-group">
    <label for="cl_blog_title" class="col-sm-2 col-sm-offset-1 control-label">ブログ：タイトル<font color=red>　【必須】</font></label>
    <div class="col-sm-4">
      {form_input('cl_blog_title' , set_value('cl_blog_title', $cl_blog_title) , 'class="col-sm-4 form-control" placeholder="タイトルを入力してください。max.100文字"')}
      {if form_error('cl_blog_title')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_blog_title')}</font></label>{/if}
    </div>
    <button type="button" class="col-sm-1 col-sm-offset-3 btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">更新する</button>
  </div>
  <div class="form-group">
    <label for="cl_blog_overview" class="col-sm-3 control-label">ブログ：概　　要</label>
    <div class="col-sm-7">
      <textarea class="form-control input-sm" id="cl_blog_overview" name="cl_blog_overview" placeholder="概要を入力してください。max.500文字">{$cl_blog_overview}</textarea>
      {if form_error('cl_blog_overview')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_blog_overview')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_blog_status" class="col-sm-3 control-label">ブログ：使用有無<font color=red>　【必須】</font></label>
    <div class="radio">
      <label>
        <input type="radio" name="optionsRadios01" id="optionsRadios1" value="0" {if $cl_blog_status==0}checked{/if}>使用する
      </label>
      <label>　　
        <input type="radio" name="optionsRadios01" id="optionsRadios2" value="1" {if $cl_blog_status==1}checked{/if}>使用しない
      </label>
    </div>
  </div>


  <!-- Button trigger modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ID　および　パスワード更新</h4>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='idpw' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal fade" id="myModal02" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ブログ　基本設定</h4>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='blog' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

{form_close()}


<br><br>
{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
