<!DOCTYPE html>
<html class="no-js" lang="jp">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>プラットフォーム &#xB7; FNOTE</title>

{* Versionと並び順に注意 *}
<link href="{base_url()}../../css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{base_url()}../../js/bootstrap.min.js"></script>

</head>

<div>
  <section class="container">
  <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
  <div class="row">

  </div>

<body>

<H3><p class="bg-info">事業者プラットフォーム　：　お問合せフォーム</p></H3>

{form_open('site/inquiry_conf/' , 'name="InquiryForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="co_contact_name" class="col-sm-3 control-label">お名前<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('co_contact_name' , set_value('co_contact_name', '') , 'class="form-control" placeholder="お名前を入力してください。max.50文字"')}
      {if form_error('co_contact_name')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_name')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="co_contact_mail" class="col-sm-3 control-label">メールアドレス<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('co_contact_mail' , set_value('co_contact_mail', '') , 'class="form-control" placeholder="ご利用プランを入力してください"')}
      {if form_error('co_contact_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_mail')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="co_contact_tel" class="col-sm-3 control-label">電話番号</label>
    <div class="col-sm-8">
      {form_input('co_contact_tel' , set_value('co_contact_tel', '') , 'class="form-control" placeholder="ご利用プランを入力してください"')}
      {if form_error('co_contact_tel')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_tel')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="co_contact_body" class="col-sm-3 control-label">お問合せ内容<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {$attr01['name'] = 'co_contact_body'}
      {$attr01['rows'] = 10}
      {form_textarea($attr01 , set_value('co_contact_body', '') , 'class="form-control"')}
      <!-- <textarea class="form-control" id="inputComment" rows="5"></textarea> -->
      {if form_error('co_contact_body')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_body')}</font></label>{/if}
    </div>
  </div>
</section>

  {form_hidden('tp_cl_siteid', $tp_cl_siteid)}

  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      {$attr['name'] = 'submit'}
      {$attr['type'] = 'submit'}
      {form_button($attr , '確　　認' , 'class="btn btn-default"')}
    </div>
  </div>

{form_close()}

<!-- </form> -->


<br><br>
<div class="panel panel-default">
  <div class="panel-footer text-center">
    Copyright(C) 2016 - {{$smarty.now|date_format:"%Y"}} Themis Inc. All Rights Reserved.
  </div>
</div>

</body>
</html>
