{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<!-- summernote.jsのロード -->
<link href="../../../wysiwyg_summemote/summernote.css" rel="stylesheet" type="text/css">
<script src="../../../wysiwyg_summemote/summernote.min.js"></script>
<script src="../../../wysiwyg_summemote/lang/summernote-ja-JP.js"></script>

<body>
{* ヘッダー部分　END *}

<p class="bg-info">　■　登録・編集</p>

<div class="form-group">
{if $err_mes}<br><label class="col-sm-10 col-sm-offset-1 control-label"><font color=red>【エラー】：{$err_mes}</font></label><br><br>{/if}
</div>

<!-- <form> -->
{form_open('tenpo_menu/comp/' , 'name="detailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="mn_name" class="col-sm-2 control-label">タイトル</label>
    <div class="col-sm-7">
      {form_input('mn_name' , set_value('mn_name', $list.mn_name) , 'class="form-control" placeholder="タイトルを入力してください。max.20文字"')}
      {if form_error('mn_name')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mn_name')}</font></label>{/if}
    </div>
  </div>
  {if $list.mn_level==3}
  <div class="form-group">
    <label for="mn_menu" class="col-sm-2 control-label">メニュー名称</label>
    <div class="col-sm-7">
      {form_input('mn_menu' , set_value('mn_menu', $list.mn_menu) , 'class="form-control" placeholder="メニュー名称を入力してください。max.20文字"')}
      {if form_error('mn_menu')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mn_menu')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="mn_price" class="col-sm-2 control-label">価格</label>
    <div class="col-sm-2">
      {form_input('mn_price' , set_value('mn_price', $list.mn_price) , 'class="form-control" placeholder="価格を入力してください。"')}
      {if form_error('mn_price')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('mn_price')}</font></label>{/if}
    </div>
  </div>
  {/if}

  <div class="radio">
    <label class="col-sm-2 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios1" value="0" {if $list.mn_status==0}checked{/if}>公開する
    </label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios2" value="1" {if $list.mn_status==1}checked{/if}>非公開にする
    </label>
  </div>

  {if $list.mn_level==3}
  <br><br>
  <div class="form-group">
    <label for="mn_info" class="col-sm-2 control-label">メニュー説明文</label>
    <div class="col-sm-8">
      <div id="summernote" name="area"><p>{$list.mn_info}</p></div>
    </div>
  </div>
  {/if}

  {form_hidden('mn_seq', $list.mn_seq)}

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
          <h4 class="modal-title">店舗メニュー情報　更新</h4>
        </div>
        <div class="modal-body">
          <p>更新しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='_chg' class="btn btn-sm btn-primary" onclick="fmSubmit('detailForm', '/client/tenpo_menu/comp/', 'POST');">O  K</button>
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
          <h4 class="modal-title">店舗メニュー情報　削除</h4>
        </div>
        <div class="modal-body">
          <p>削除しますか。&hellip;</p>
          <p>削除する場合、該当階層以下のメニューも削除されます。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='_del' class="btn btn-sm btn-primary" onclick="fmSubmit('detailForm', '/client/tenpo_menu/comp/', 'POST');">O  K</button>
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
