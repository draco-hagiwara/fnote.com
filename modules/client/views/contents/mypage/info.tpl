{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}


{form_open('/mypage/info/' , 'name="idpwForm" class="form-horizontal"')}

<p class="bg-info">　【 ログイン・パスワード　変更 】</p>

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

<br><hr>

<p class="bg-info">　【 ブログ　基本項目設定 】</p>

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

<br><hr>

<p class="bg-info">　【 画像カテゴリ分類名称　設定 】</p>

  <div class="form-group">
    <label for="cl_blog_title" class="col-sm-2 col-sm-offset-1 control-label">画像カテゴリ分類名称</label>
    <div class="col-sm-2">
      {form_input('ci_name01' , set_value('ci_name01', $ci_cate.ci_name01) , 'class="col-sm-4 form-control" placeholder="名称。max.10文字"')}
      {if form_error('ci_name01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ci_name01')}</font></label>{/if}
    </div>
    <div class="radio col-sm-3">
      <label>
        <input type="radio" name="optionsRadios01" id="optionsRadios1" value="0" {if $ci_cate.ci_status01==0}checked{/if}>使用する
      </label>
      <label>　　
        <input type="radio" name="optionsRadios01" id="optionsRadios2" value="1" {if $ci_cate.ci_status01==1}checked{/if}>使用しない
      </label>
    </div>
    <button type="button" class="col-sm-1 col-sm-offset-2 btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal03">更新する</button>
  </div>
  <div class="form-group">
    <div class="col-sm-2 col-sm-offset-3">
      {form_input('ci_name02' , set_value('ci_name02', $ci_cate.ci_name02) , 'class="col-sm-4 form-control" placeholder="名称。max.10文字"')}
      {if form_error('ci_name02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ci_name02')}</font></label>{/if}
    </div>
    <div class="radio col-sm-4">
      <label>
        <input type="radio" name="optionsRadios02" id="optionsRadios1" value="0" {if $ci_cate.ci_status02==0}checked{/if}>使用する
      </label>
      <label>　　
        <input type="radio" name="optionsRadios02" id="optionsRadios2" value="1" {if $ci_cate.ci_status02==1}checked{/if}>使用しない
      </label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-2 col-sm-offset-3">
      {form_input('ci_name03' , set_value('ci_name03', $ci_cate.ci_name03) , 'class="col-sm-4 form-control" placeholder="名称。max.10文字"')}
      {if form_error('ci_name03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ci_name03')}</font></label>{/if}
    </div>
    <div class="radio col-sm-4">
      <label>
        <input type="radio" name="optionsRadios03" id="optionsRadios1" value="0" {if $ci_cate.ci_status03==0}checked{/if}>使用する
      </label>
      <label>　　
        <input type="radio" name="optionsRadios03" id="optionsRadios2" value="1" {if $ci_cate.ci_status03==1}checked{/if}>使用しない
      </label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-2 col-sm-offset-3">
      {form_input('ci_name04' , set_value('ci_name04', $ci_cate.ci_name04) , 'class="col-sm-4 form-control" placeholder="名称。max.10文字"')}
      {if form_error('ci_name04')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ci_name04')}</font></label>{/if}
    </div>
    <div class="radio col-sm-4">
      <label>
        <input type="radio" name="optionsRadios04" id="optionsRadios1" value="0" {if $ci_cate.ci_status04==0}checked{/if}>使用する
      </label>
      <label>　　
        <input type="radio" name="optionsRadios04" id="optionsRadios2" value="1" {if $ci_cate.ci_status04==1}checked{/if}>使用しない
      </label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-2 col-sm-offset-3">
      {form_input('ci_name05' , set_value('ci_name05', $ci_cate.ci_name05) , 'class="col-sm-4 form-control" placeholder="名称。max.10文字"')}
      {if form_error('ci_name05')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ci_name05')}</font></label>{/if}
    </div>
    <div class="radio col-sm-4">
      <label>
        <input type="radio" name="optionsRadios05" id="optionsRadios1" value="0" {if $ci_cate.ci_status05==0}checked{/if}>使用する
      </label>
      <label>　　
        <input type="radio" name="optionsRadios05" id="optionsRadios2" value="1" {if $ci_cate.ci_status05==1}checked{/if}>使用しない
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

  <div class="modal fade" id="myModal03" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">画像カテゴリ分類名称　設定</h4>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='image' class="btn btn-sm btn-primary">O  K</button>
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
