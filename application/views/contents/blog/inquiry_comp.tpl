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

{form_open($_site_url , 'name="InquiryForm" class="form-horizontal"')}

 <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      {$attr01['name'] = '_back'}
      {$attr01['type'] = 'submit'}
      {$attr01['value'] = '_site'}
      {form_button($attr01 , 'ブログTOPへ' , 'class="btn btn-default"')}
    </div>
  </div>

</section>

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
