{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>アカウント情報　　<span class="label label-success">新規登録</span></h3>
</div>

{form_open('contact/confirm/' , 'name="ContactForm" class="form-horizontal"')}
<!-- <form class="form-horizontal" name="ContactForm" method="post" action="contact/confirm/"> -->
  <div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">名　前<font color=red>【必須】</font></label>
    <div class="col-sm-10">
      {form_input('inputName' , set_value('inputName', '') , 'class="form-control" placeholder="名前を入力してください"')}
      <!-- <input type="text" class="form-control" id="inputName" placeholder="名前を入力してください"> -->
      {if form_error('inputName')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('inputName')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">メールアドレス<font color=red>【必須】</font></label>
    <div class="col-sm-10">
      {form_input('inputEmail' , set_value('inputEmail', '') , 'class="col-sm-2 form-control" placeholder="メールアドレスを入力してください"')}
      <!-- <input type="email" class="col-sm-2 form-control" id="inputEmail" placeholder="メールアドレスを入力してください"> -->
      {if form_error('inputEmail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('inputEmail')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="inputTel" class="col-sm-2 control-label">連絡先電話番号</label>
    <div class="col-sm-10">
      {form_input('inputTel' , set_value('inputTel', '') , 'class="form-control" placeholder="連絡先の電話番号を入力してください"')}
      <!-- <input type="text" class="form-control" id="inputTel" placeholder="連絡先の電話番号を入力してください"> -->
      {if form_error('inputTel')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('inputTel')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="inputComment" class="col-sm-2 control-label">お問合せ内容</label>
    <div class="col-sm-10">
      {$attr01['name'] = 'inputComment'}
      {$attr01['rows'] = 10}
      {form_textarea($attr01 , set_value('inputComment', '') , 'class="form-control"')}
      <!-- <textarea class="form-control" id="inputComment" rows="5"></textarea> -->
      {if form_error('inputComment')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('inputComment')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      {$attr02['name'] = 'submit'}
      {$attr02['type'] = 'submit'}
      {form_button($attr02 , '確　　認' , 'class="btn btn-default"')}
      <!-- <button type="submit" class="btn btn-default">確　　認</button> -->
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
