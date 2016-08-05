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

<br>
<div class="row">
  <div class="col-md-3"><a href="https://{$smarty.server.HTTP_HOST}/blog/pf/{$artcle_list.bar_cl_siteid}">← ブログ一覧へ戻る</a></div>
</div>

<H3><p class="bg-info">{$smarty.session.blog_title}</p></H3>

  <div class="form-group">
    【{$artcle_list.bar_subject}】<br><br>
    {$artcle_list.bar_text}<br><br>
    {$artcle_list.bar_date}　　コメント({$comment_cnt})
  </div>

  {if $comment_cnt!=0}
  <div class="form-horizontal col-sm-11 col-sm-offset-1">
    <table class="table">

        {foreach from=$comment_list item=bl  name="seq"}
        <tbody>
            <tr>
                <td>
                  <div class="form-group">
                   【{$smarty.foreach.seq.iteration}】
                    {$bl.bcm_date}　　{$bl.bcm_name}
                    　　{if $bl.bcm_mail}<a href="mailto:{$bl.bcm_mail}">MAIL</a>{/if}
                    　　{if $bl.bcm_url}<a href="{$bl.bcm_url}" target="_blank">URL</a>{/if}
                    <br><br>
                    {$bl.bcm_text|nl2br}<br>
                  </div>
                </td>
            </tr>
        </tbody>
        {foreachelse}
            コメントはありませんでした。
        {/foreach}

    </table>
  </div>
  {/if}

</section>


<section class="container">

<p class="bg-info">　コメント入力フォーム</p>
{form_open("/blog/detail/$siteid/$bar_seq" , 'name="detailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="bcm_name" class="col-sm-3 control-label">お名前<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {form_input('bcm_name' , set_value('bcm_name', '') , 'class="form-control" placeholder="お名前(ニックネーム)を入力してください"')}
      {if form_error('bcm_name')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bcm_name')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="bcm_mail" class="col-sm-3 control-label">メールアドレス</label>
    <div class="col-sm-8">
      {form_input('bcm_mail' , set_value('bcm_mail', '') , 'class="form-control" placeholder="メールアドレスを入力してください"')}
      {if form_error('bcm_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bcm_mail')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="bcm_url" class="col-sm-3 control-label">URL</label>
    <div class="col-sm-8">
      {form_input('bcm_url' , set_value('bcm_url', '') , 'class="form-control" placeholder="http(s):// からURLを入力してください"')}
      {if form_error('bcm_url')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bcm_url')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="bcm_text" class="col-sm-3 control-label">コメント<font color=red>【必須】</font></label>
    <div class="col-sm-8">
      {$attr01['name'] = 'bcm_text'}
      {$attr01['rows'] = 10}
      {form_textarea($attr01 , set_value('bcm_text', '') , 'class="form-control"')}
      <!-- <textarea class="form-control" id="inputComment" rows="5"></textarea> -->
      {if form_error('bcm_text')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bcm_text')}</font></label>{/if}
    </div>
  </div>
</section>

{form_hidden('bar_seq', $bar_seq)}

  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">登録する</button>
  </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ブログコメント　登録</h4>
        </div>
        <div class="modal-body">
          <p>登録しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='submit' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

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
