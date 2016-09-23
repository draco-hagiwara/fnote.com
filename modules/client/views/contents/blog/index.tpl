{* ヘッダー部分　START *}
    {include file="../header_wysiwyg.tpl" head_index="1"}


<!-- summernote.jsのロード -->
<link href="../../wysiwyg_summemote/summernote.css" rel="stylesheet" type="text/css">
<script src="../../wysiwyg_summemote/summernote.min.js"></script>
<script src="../../wysiwyg_summemote/lang/summernote-ja-JP.js"></script>


<body>
{* ヘッダー部分　END *}

{if $cl.cl_blog_status == 0}
  <a href="https://{$smarty.server.HTTP_HOST}/blog/pf/{$cl.cl_siteid}" target="_blank">{$cl.cl_siteid}ブログ はこちら</a>
<br><br>
{/if}

<p class="bg-info">　■　投稿一覧</p>

{form_open('blog/detail/' , 'name="blogForm" class="form-horizontal"')}

  <div class="row">
    <div class="col-sm-2 col-sm-offset-1">{$set_pagination}</div>
    <div class="col-sm-2 col-sm-offset-7">登録件数： {$countall}件</div>
  </div>

  <div class="form-horizontal col-sm-11 col-sm-offset-1">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>status</th>
          <th class="col-sm-2">日　時</th>
          <th>題　　　名</th>
          <th></th>
        </tr>
      </thead>

      {foreach from=$list item=bl  name="seq"}
        <tbody>
          <tr>
            <td>
              {$smarty.foreach.seq.iteration}
            </td>
            <td>
              {if $bl.bar_status == "0"}<font color="#ffffff" style="background-color:blue">公　開</font>
              {elseif $bl.bar_status == "1"}<font color="#ffffff" style="background-color:gray">非公開</font>
              {else}エラー
              {/if}
            </td>
            <td>
              {$bl.bar_date}
            </td>
            <td>
              {$bl.bar_subject}
            </td>
            <td>
              <button type="submit" class="btn btn-success btn-xs" name="chg_uniq" value="{$bl.bar_seq}">編集</button>
            </td>
          </tr>
        </tbody>
      {foreachelse}
        検索結果はありませんでした。
      {/foreach}

    </table>
  </div>


</section>

{form_close()}


<section class="container">
<p class="bg-info">　■　新規投稿・編集/削除</p>

{form_open('blog/detail/' , 'name="blogdetailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="bar_subject" class="col-sm-2 control-label">題　　名</label>
    <div class="col-sm-6">
      {form_input('bar_subject' , set_value('bar_subject', $low.bar_subject) , 'class="form-control" placeholder="題名を入力してください。max.50文字"')}
      {if form_error('bar_subject')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bar_subject')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="bar_tag" class="col-sm-2 control-label">タ　　グ</label>
    <div class="col-sm-6">
      {form_input('bar_tag' , set_value('bar_tag', $low.bar_tag) , 'class="form-control" placeholder="タグ（カンマ「，」区切り）を入力してください。max.50文字"')}
      {if form_error('bar_tag')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bar_tag')}</font></label>{/if}
    </div>
  </div>

  <div class="radio">
    <label class="col-sm-2 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios1" value="0" {if $low.bar_comment==0}checked{/if}>コメント受付あり
    </label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios2" value="1" {if $low.bar_comment==1}checked{/if}>コメント受付なし
    </label>
  </div>

  <div class="radio">
    <label class="col-sm-2 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios02" id="optionsRadios1" value="0" {if $low.bar_status==0}checked{/if}>公開
    </label>
    <label>
      <input type="radio" name="optionsRadios02" id="optionsRadios2" value="1" {if $low.bar_status==1}checked{/if}>非公開
    </label>
  </div><br />

  <div class="form-group">
    <label for="bar_subject" class="col-sm-2 control-label">本　　文</label>
    <div class="col-sm-8">
      <div id="summernote" name="area"><p>{$low.bar_text}</p></div>
    </div>
  </div>

  {form_hidden('bar_seq', $bar_seq)}


  <br>
  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">新規登録 or 編集</button>
  </div>
  <div class="col-sm-2 col-sm-offset-1">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">削除する</button>
  </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">ブログ　登録または編集</h4>
        </div>
        <div class="modal-body">
          <p>実行しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='addorchg' class="btn btn-sm btn-primary" onclick="fmSubmit('blogdetailForm', '/client/blog/detail/', 'POST');">O  K</button>
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
          <h4 class="modal-title">ブログ　削除</h4>
        </div>
        <div class="modal-body">
          <p>削除しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='delete' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<script>
    $('#summernote').summernote({
      height: 300,
      fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
      lang: "ja-JP",
    });
</script>


{form_close()}

<!-- </form> -->


<script type="text/javascript">
<!--
function fmSubmit(formName, url, method) {
  var f1 = document.forms[formName];

  /*console.log(num);

  /* エレメント作成&データ設定&要素追加 */
  var e1 = document.createElement('input');

  e1.setAttribute('type', 'hidden');
  e1.setAttribute('name', 'area');
  e1.setAttribute('value', $('#summernote').summernote('code'));
  f1.appendChild(e1);

  /* サブミットするフォームを取得 */
  f1.method = method;                                   // method(GET or POST)を設定する
  f1.action = url;                                      // action(遷移先URL)を設定する
  f1.submit();                                          // submit する
  return true;
}
// -->
</script>


<br><br><br>
{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
