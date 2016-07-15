<!DOCTYPE html>
<html class="no-js" lang="jp">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>CS &#xB7; Crowd Sourcing</title>

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

<H3><p class="bg-info">事業者プラットフォーム</p></H3>


{form_open('site/inquiry_comp/' , 'name="InquiryForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="co_contact_name" class="col-sm-3 control-label">お名前<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('co_contact_name', '')}
      {form_hidden('co_contact_name', set_value('co_contact_name', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="co_contact_mail" class="col-sm-3 control-label">メールアドレス<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('co_contact_mail', '')}
      {form_hidden('co_contact_mail', set_value('co_contact_mail', ''))}
    </div>
  </div>
    <div class="form-group">
    <label for="co_contact_tel" class="col-sm-3 control-label">電話番号</label>
    <div class="col-sm-9">
      {set_value('co_contact_tel', '')}
      {form_hidden('co_contact_tel', set_value('co_contact_tel', ''))}
    </div>
  </div>
    <div class="form-group">
    <label for="co_contact_body" class="col-sm-3 control-label">お問合せ内容<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('co_contact_body', '')}
      {form_hidden('co_contact_body', set_value('co_contact_body', ''))}
    </div>
  </div>

</section>

{form_hidden('en_cl_siteid', $en_cl_siteid)}

 <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      {$attr01['name'] = '_back'}
      {$attr01['type'] = 'submit'}
      {$attr01['value'] = '_back'}
      {form_button($attr01 , '戻　　る' , 'class="btn btn-default"')}

      {$attr02['name'] = 'submit'}
      {$attr02['type'] = 'submit'}
      {form_button($attr02 , '送　　信' , 'class="btn btn-default"')}
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
