{* ヘッダー部分　START *}
    {include file="../header_wysiwyg.tpl" head_index="1"}


<!-- summernote.jsのロード -->
<link href="../../wysiwyg_summemote/summernote.css" rel="stylesheet" type="text/css">
<script src="../../wysiwyg_summemote/summernote.min.js"></script>
<script src="../../wysiwyg_summemote/lang/summernote-ja-JP.js"></script>


<body>
{* ヘッダー部分　END *}

<p class="bg-info">　■　投稿一覧</p>

{form_open('newslist/detail/' , 'name="newsForm" class="form-horizontal"')}

<ul class="pagination pagination-sm">
    登録件数： {$countall}件<br />
    {$set_pagination}
</ul>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>状態</th>
                <th>Type</th>
                <th>表示日付</th>
                <th>タイトル</th>
                <th></th>
            </tr>
        </thead>


        {foreach from=$list item=nw  name="seq"}
        <tbody>
            <tr>
                <td>
                    {$smarty.foreach.seq.iteration}
                </td>
                <td>
                    {if $nw.nw_status == "0"}<font color="#ffffff" style="background-color:blue">表　示</font>
                    {elseif $nw.nw_status == "1"}<font color="#ffffff" style="background-color:gray">非表示</font>
                    {else}エラー
                    {/if}
                </td>
                <td>
                    {if $nw.nw_type == "0"}<font color="#ffffff" style="background-color:#CC00FF">新着情報</font>
                    {elseif $nw.nw_type == "1"}<font color="#ffffff" style="background-color:#66CC33">お知らせ</font>
                    {else}エラー
                    {/if}
                </td>
                <td>
                    {$nw.nw_start_date}
                </td>
                <td>
                    {$nw.nw_title|escape}
                </td>
                <td>
                    <button type="submit" class="btn btn-success btn-xs" name="chg_uniq" value="{$nw.nw_seq}">編集</button>
                </td>
            </tr>
        </tbody>
        {foreachelse}
            検索結果はありませんでした。
        {/foreach}

    </table>

{form_close()}





<br><br><br>
<p class="bg-info">　■　登録・編集</p>


{form_open('newslist/detail/' , 'name="newsdetailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="nw_title" class="col-sm-1 control-label">タイトル</label>
    <div class="col-sm-5">
      {form_input('nw_title' , set_value('nw_title', $low.nw_title) , 'class="form-control" placeholder="タイトルを入力してください。max.50文字"')}
      {if form_error('nw_title')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('nw_title')}</font></label>{/if}
    </div>
    <label for="nw_start_date" class="col-sm-1 control-label">開始日付</label>
    <div class="col-sm-2">
      {form_input('nw_start_date' , set_value('nw_start_date', $low.nw_start_date) , 'class="form-control" placeholder="形式：20xx-xx-xx"')}
      {if form_error('nw_start_date')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('nw_start_date')}</font></label>{/if}
    </div>
    <label for="nw_end_date" class="col-sm-1 control-label">終了日付</label>
    <div class="col-sm-2">
      {form_input('nw_end_date' , set_value('nw_end_date', $low.nw_end_date) , 'class="form-control" placeholder="形式：20xx-xx-xx"')}
      {if form_error('nw_end_date')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('nw_end_date')}</font></label>{/if}
    </div>
  </div>

  <div class="radio">
    <label class="col-sm-1 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios1" value="0" checked>新着
    </label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios2" value="1">お知らせ
    </label>
  </div>

  <div class="radio">
    <label class="col-sm-1 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios02" id="optionsRadios1" value="0" checked>表示
    </label>
    <label>
      <input type="radio" name="optionsRadios02" id="optionsRadios2" value="1">非表示
    </label>
  </div>

  <br><br>
  <div class="form-group">
    <label for="nw_body" class="col-sm-1 control-label">本　　文</label>
    <div class="col-sm-8">
      <div id="summernote" name="area"><p>{$low.nw_body}</p></div>
    </div>
  </div>

  {form_hidden('nw_seq', $nw_seq)}

  <br><br>
  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">更新する</button>
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
          <h4 class="modal-title">新着・お知らせ情報　更新</h4>
        </div>
        <div class="modal-body">
          <p>更新しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='addorchg' class="btn btn-sm btn-primary" onclick="fmSubmit('newsdetailForm', '/client/newslist/detail/', 'POST');">O  K</button>
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
          <h4 class="modal-title">新着・お知らせ情報　削除</h4>
        </div>
        <div class="modal-body">
          <p>削除しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='delete' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<script>
    $('#summernote').summernote({
      height: 200,
      fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
      lang: "ja-JP",
    });
</script>


{form_close()}


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


<!-- </form> -->



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
