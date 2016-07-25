{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>会社情報</h3>
</div>

{form_open('entryconf/cl_complete/' , 'name="ConfirmForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="cl_siteid" class="col-sm-4 control-label">サイトID(URL名)</label>
    <div class="col-sm-8">
      {$list.cl_siteid}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_id" class="col-sm-4 control-label">ログインID</label>
    <div class="col-sm-8">
      {$list.cl_id}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">会社名</label>
    <div class="col-sm-8">
      {$list.cl_company}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_president" class="col-sm-4 control-label">代表者(承認メール宛先)</label>
    <div class="col-sm-8">
      {$list.cl_president01}　{$list.cl_president02}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_department" class="col-sm-4 control-label">所属部署</label>
    <div class="col-sm-8">
      {$list.cl_department}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_person" class="col-sm-4 control-label">担当者</label>
    <div class="col-sm-8">
      {$list.cl_person01}　{$list.cl_person02}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_tel" class="col-sm-4 control-label">担当者電話番号</label>
    <div class="col-sm-8">
      {$list.cl_tel}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mobile" class="col-sm-4 control-label">担当者携帯番号</label>
    <div class="col-sm-8">
      {$list.cl_mobile}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_fax" class="col-sm-4 control-label">FAX番号</label>
    <div class="col-sm-8">
      {$list.cl_fax}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mail" class="col-sm-4 control-label">メールアドレス(承認メール送信先)</label>
    <div class="col-sm-8">
      {$list.cl_mail}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_mailsub" class="col-sm-4 control-label">メールアドレス(サブ)</label>
    <div class="col-sm-8">
      {$list.cl_mailsub}
    </div>
  </div>

{form_close()}

<br><br><br><br>
  <div class="form-group col-sm-8 col-sm-offset-2">
    <u>※登録内容の変更をご希望される場合は、<strong>メニュー 「その他->サポート問合せ」 </strong>よりご連絡ください。</u>
  </div>

{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{*include file="../footer.tpl"*}
{* フッター部分　END *}

</body>
</html>
