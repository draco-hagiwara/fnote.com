{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<script type="text/javascript">
<!--
function fmSubmit(formName, url, method, num, type) {
  var f1 = document.forms[formName];

  console.log(num);

  /* エレメント作成&データ設定&要素追加 */
  var e1 = document.createElement('input');
  e1.setAttribute('type', 'hidden');
  e1.setAttribute('name', type);
  e1.setAttribute('value', num);
  f1.appendChild(e1);

  /* サブミットするフォームを取得 */
  f1.method = method;                                   // method(GET or POST)を設定する
  f1.action = url;                                      // action(遷移先URL)を設定する
  f1.submit();                                          // submit する
  return true;
}
// -->
</script>

<script type="text/javascript">
$(function(){
    $('#iv_title01,#iv_title02').bind('keyup',function() {
        for ( num=1; num<=4; num++ ) {
            var max = 501;
            var min = 0;
            var thisValueLength = $("#iv_title0" + num).val().replace(/\s+/g,'').length;

            if (thisValueLength <= min || thisValueLength >= max) {
                $(".count" + num).addClass('red');
            } else {
                $(".count" + num).removeClass('red');
            }
            $(".count" + num).html(thisValueLength);
        }
    });

    $('#iv_body01,#iv_body02').bind('keyup',function() {
        for ( num=1; num<=4; num++ ) {
            var max = 5001;
            var min = 0;
            var thisValueLength = $("#iv_body0" + num).val().replace(/\s+/g,'').length;

            if (thisValueLength <= min || thisValueLength >= max) {
                $(".cnt" + num).addClass('red');
            } else {
                $(".cnt" + num).removeClass('red');
            }
            $(".cnt" + num).html(thisValueLength);
        }
    });
});
</script>


<style type="text/css">
.bold{
    font-weight: bold;
}
.red{
    color:#ff0000;
}
</style>


<H3><p class="bg-success">店舗（クライアント）　記事本文情報設定</p></H3>

<form method="post" target="_blank" action="../../../preview/pf/">

  <div class="form-group">
    <div class="col-sm-offset-10 col-sm-2">
      一時保存 ->
      <button type='submit' name='_submit' value='preview' class="btn btn-sm btn-primary">プレビュー</button>
    </div>
  </div>

  <input type="hidden" name="iv_seq" value={$list.iv_seq}>
  <input type="hidden" name="type"   value="body">
  <input type="hidden" name="ticket" value={$ticket}>

</form>


<br><br>
{form_open('tenpo_interview/report_conf/' , 'name="EntrytenpoForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="iv_title01" class="col-sm-2 control-label">タイトル<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="iv_title01" name="iv_title01" placeholder="タイトルを入力してください。目安.500文字">{$list.iv_title01}</textarea>
      {if form_error('iv_title01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('iv_title01')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="count1 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="iv_body01" class="col-sm-2 control-label">記事本文<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" rows="10" id="iv_body01" name="iv_body01" placeholder="記事本文を入力してください。目安.5,000文字">{$list.iv_body01}</textarea>
      {if form_error('iv_body01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('iv_body01')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="cnt1 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="iv_title02" class="col-sm-2 control-label">タイトルサブ</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="iv_title02" name="iv_title02" placeholder="タイトルサブを入力してください。目安.500文字">{$list.iv_title02}</textarea>
      {if form_error('iv_title02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('iv_title02')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="count2 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="iv_body02" class="col-sm-2 control-label">記事本文サブ</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="iv_body02" name="iv_body02" placeholder="記事本文サブを入力してください。目安.5,000文字">{$list.iv_body02}</textarea>
      {if form_error('iv_body02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('iv_body02')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="cnt2 bold red">0</span>
    </div>
  </div>
  {*
  <div class="form-group">
    <label for="iv_entry_tags" class="col-sm-2 control-label">タグ</label>
    <div class="col-sm-10">
      <textarea class="form-control input-sm" id="iv_entry_tags" name="iv_entry_tags" placeholder="タグを入力してください。max.255文字">{$list.iv_entry_tags}</textarea>
      {if form_error('iv_entry_tags')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('iv_entry_tags')}</font></label>{/if}
    </div>
  </div>
  *}
  <input type="hidden" name="iv_seq" value={$list.iv_seq}>
  <input type="hidden" name="cl_status" value={$cl_status}>


  <!-- Button trigger modal -->
  <div class="row">
    <div class="col-sm-4 col-sm-offset-2">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">登録する</button>
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">一時保存</button>
      {if $cl_status == "4" OR $cl_status == "9"}
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal03">営業 確認</button>
      {/if}
    </div>
    <div class="col-sm-2 col-sm-offset-4">
      <button type="button" class="btn btn-primary btn-sm" onclick="fmSubmit('EntrytenpoForm', '/admin/tenpo_site/tenpo_edit/', 'POST', '{$smarty.session.a_cl_seq}', 'chg_uniq');">店舗情報</button>
      <button type="button" class="btn btn-primary btn-sm" onclick="fmSubmit('EntrytenpoForm', '/admin/gallery/gd_list/', 'POST', '{$smarty.session.a_cl_seq}', 'chg_uniq');">画像管理</button>
    </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">店舗記事情報　登録</h4>
        </div>
        <div class="modal-body">
          <p>登録しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='save' class="btn btn-sm btn-primary">O  K</button>
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
          <h4 class="modal-title">店舗記事情報　一時保存</h4>
        </div>
        <div class="modal-body">
          <p>一時保存された内容がプレビュー表示されます。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='preview' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal fade" id="myModal03" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">営業 確認</h4>
        </div>
        <div class="modal-body">
          <p>編集が終了し、営業への確認＆承認依頼を行います。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='salse' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <hr>

  <div class="form-group">
    <label for="rv_description" class="col-sm-2 control-label">【レビジョン管理】</label>
  </div>
  <div class="form-group">
    <label for="rv_description" class="col-sm-2 control-label"> 保存タイトル</label>
    <div class="col-sm-7">
      {form_input('rv_description' , set_value('rv_description', '') , 'class="form-control" placeholder="保存タイトルを入力してください。max.50文字"')}
      {if form_error('rv_description')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('rv_description')}</font></label>{/if}
    </div>
  </div>

  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-4 col-sm-offset-2">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal04">現在の内容をバックアップ (max.5)</button>
  </div>
  </div>

  <div class="modal fade" id="myModal04" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">店舗記事情報　バックアップ</h4>
        </div>
        <div class="modal-body">
          <p>保存しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value=revision class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


{form_close()}
<!-- </form> -->

<br>
{form_open('/tenpo_interview/report_rev/' , 'name="detailForm" class="form-horizontal"')}

  <div class="form-horizontal col-sm-10 col-sm-offset-2">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>タイトル</th>
          <th>保存日付</th>
          <th></th>
        </tr>
      </thead>

      {foreach from=$revlist item=rv name="seq"}
      <tbody>
        <tr>
          <td>
            {$smarty.foreach.seq.iteration}
          </td>
          <td>
            {$rv.rv_description}
          </td>
          <td>
            {$rv.rv_update_date}
          </td>
          <td>
            <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/admin/tenpo_interview/report_rev/', 'POST', '{$rv.rv_seq}', 'chg_uniq');">復　元</button>
            <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/admin/tenpo_interview/report_rev/', 'POST', '{$rv.rv_seq}', 'del_uniq');">削　除</button>
          </td>
        </tr>
      </tbody>
        {foreachelse}
          検索結果はありませんでした。
        {/foreach}

    </table>
  </div>


{form_close()}


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
