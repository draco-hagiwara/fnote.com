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
    $('#gd_title01,#gd_title02,#gd_title03,#gd_title04').bind('keyup',function() {
        for ( num=1; num<=4; num++ ) {
            var max = 51;
            var min = 0;
            var thisValueLength = $("#gd_title0" + num).val().replace(/\s+/g,'').length;

            if (thisValueLength <= min || thisValueLength >= max) {
                $(".count" + num).addClass('red');
            } else {
                $(".count" + num).removeClass('red');
            }
            $(".count" + num).html(thisValueLength);
        }
    });

    $('#gd_body01,#gd_body02,#gd_body03,#gd_body04').bind('keyup',function() {
        for ( num=1; num<=4; num++ ) {
            var max = 251;
            var min = 0;
            var thisValueLength = $("#gd_body0" + num).val().replace(/\s+/g,'').length;

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

<H3><p class="bg-success">店舗（クライアント）　こだわり情報設定</p></H3>

<br><br>
{form_open('tenpo_good/conf/' , 'name="EntrytenpoForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="gd_title01" class="col-sm-2 control-label">タイトル１<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="gd_title01" name="gd_title01" placeholder="タイトルを入力してください。目安.50文字">{$list.gd_title01}</textarea>
      {if form_error('gd_title01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gd_title01')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="count1 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="gd_body01" class="col-sm-2 control-label">記事本文１<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" rows="5" id="gd_body01" name="gd_body01" placeholder="記事本文を入力してください。目安.250文字">{$list.gd_body01}</textarea>
      {if form_error('gd_body01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gd_body01')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="cnt1 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="gd_title02" class="col-sm-2 control-label">タイトル２</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="gd_title02" name="gd_title02" placeholder="タイトルサブを入力してください。目安.50文字">{$list.gd_title02}</textarea>
      {if form_error('gd_title02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gd_title02')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="count2 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="gd_body02" class="col-sm-2 control-label">記事本文２</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="gd_body02" name="gd_body02" placeholder="記事本文サブを入力してください。目安.250文字">{$list.gd_body02}</textarea>
      {if form_error('gd_body02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gd_body02')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="cnt2 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="gd_title03" class="col-sm-2 control-label">タイトル３</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="gd_title03" name="gd_title03" placeholder="タイトルサブを入力してください。目安.50文字">{$list.gd_title03}</textarea>
      {if form_error('gd_title03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gd_title03')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="count3 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="gd_body03" class="col-sm-2 control-label">記事本文３</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="gd_body03" name="gd_body03" placeholder="記事本文サブを入力してください。目安.250文字">{$list.gd_body03}</textarea>
      {if form_error('gd_body03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gd_body03')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="cnt3 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="gd_title04" class="col-sm-2 control-label">タイトル４</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="gd_title04" name="gd_title04" placeholder="タイトルサブを入力してください。目安.50文字">{$list.gd_title04}</textarea>
      {if form_error('gd_title04')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gd_title04')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="count4 bold red">0</span>
    </div>
  </div>
  <div class="form-group">
    <label for="gd_body04" class="col-sm-2 control-label">記事本文４</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="gd_body04" name="gd_body04" placeholder="記事本文サブを入力してください。目安.250文字">{$list.gd_body04}</textarea>
      {if form_error('gd_body04')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gd_body04')}</font></label>{/if}
    </div>
    <div class="col-sm-1">
      <span class="cnt4 bold red">0</span>
    </div>
  </div>

  <input type="hidden" name="gd_seq" value={$list.gd_seq}>
  <input type="hidden" name="cl_status" value={$cl_status}>


  <!-- Button trigger modal -->
  <div class="row">
    <div class="col-sm-4 col-sm-offset-2">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">登録する</button>
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
          <h4 class="modal-title">店舗こだわり情報　登録</h4>
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

{form_close()}
<!-- </form> -->


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
