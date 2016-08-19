<!DOCTYPE html>
<html class="no-js" lang="jp">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>ブログ &#xB7; FNOTE</title>

{* Versionと並び順に注意 *}
<link href="{base_url()}../../css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{base_url()}../../js/bootstrap.min.js"></script>

</head>


<body>


<div>
  <section class="container">
  <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
  <div class="row">
  </div>

<H3><p class="bg-info">{$smarty.session.blog_title}</p></H3>
{$smarty.session.blog_overview|nl2br}

<br><br>
<h4>【投稿　検索】</h4>
{form_open("/blog/pf/$siteid" , 'name="searchForm" class="form-horizontal"')}
  <table class="table table-hover table-bordered">
    <tbody>
      <tr>
        <td class="col-sm-2">キーワード</td>
        <td class="col-sm-4">
          {form_input('bl_keyword' , set_value('bl_keyword', '') , 'class="form-control" placeholder="キーワードを入力してください。"')}
          {if form_error('bl_keyword')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bl_keyword')}</font></label>{/if}
        </td>
        <td class="col-sm-2">タグ</td>
        <td class="col-sm-4">
          {form_input('bar_tag' , set_value('bar_tag', '') , 'class="form-control" placeholder="タグを入力してください。"')}
          {if form_error('bar_tag')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bar_tag')}</font></label>{/if}
        </td>
      </tr>
    </tbody>
  </table>

  <div class="row">
    <div class="col-sm-5 col-sm-offset-5">
      {$attr['name']  = 'submit'}
      {$attr['type']  = 'submit'}
      {$attr['value'] = '_submit'}
      {form_button($attr , '検　　索' , 'class="btn btn-default"')}
    </div>
  </div>


{form_close()}


  <ul class="pagination pagination-sm">
    検索結果： {$countall}件<br />
    {$set_pagination}
  </ul>




<p class="bg-info">　■　投稿一覧</p>


{form_open('blog/detail/' , 'name="blogForm" class="form-horizontal"')}


  <div class="form-horizontal col-sm-11 col-sm-offset-1">
    <table class="table">

        {foreach from=$list item=bl  name="seq"}
        <tbody>
            <tr>
                <td>
                  <div class="form-group">
                    【{$smarty.foreach.seq.iteration}】
                    {$bl.bar_subject}<br><br>
                    {$bl.bar_text}<br><br>
                    {$bl.bar_date}{if $bl.bar_comment==0}　　<a href="https://{$smarty.server.HTTP_HOST}/blog/detail/{$bl.bar_cl_siteid}/{$bl.bar_seq}">コメント({$bl.bcm_bar_seq})</a>{/if}
                  </div>
                </td>
            </tr>
        </tbody>
        {foreachelse}
            検索結果はありませんでした。
        {/foreach}

    </table>
  </div>


{form_close()}

</section>









<section class="container">

<H3><p class="bg-info">　お問合せフォーム</p></H3>
{form_open('blog/inquiry_conf/' , 'name="InquiryForm" class="form-horizontal"')}

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
      {form_input('co_contact_mail' , set_value('co_contact_mail', '') , 'class="form-control" placeholder="メールアドレスを入力してください"')}
      {if form_error('co_contact_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('co_contact_mail')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="co_contact_tel" class="col-sm-3 control-label">電話番号</label>
    <div class="col-sm-8">
      {form_input('co_contact_tel' , set_value('co_contact_tel', '') , 'class="form-control" placeholder="電話番号を入力してください"')}
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

  {form_hidden('siteid', $siteid)}

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
