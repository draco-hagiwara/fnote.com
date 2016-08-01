{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}


<script type="text/javascript">
<!--
function fmSubmit(formName, url, method, num) {
  var f1 = document.forms[formName];

  console.log(num);

  /* エレメント作成&データ設定&要素追加 */
  var e1 = document.createElement('input');
  e1.setAttribute('type', 'hidden');
  e1.setAttribute('name', 'chg_uniq');
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

<div id="contents" class="container">

<h4>【カテゴリ検索】</h4>
{form_open('/system/cate_search/' , 'name="searchForm" class="form-horizontal"')}
  <table class="table table-hover table-bordered">
    <tbody>

      <tr>
        <td class="col-sm-2">第一カテゴリ</td>
        <td class="col-sm-4">
          <select name="ca_cate01" onchange="getSelectedValAndText(this);">
            {foreach name=ca_cate01 from=$opt_ca_cate01 key=num item=item}
              {if $num == $serch_item.ca_cate01}
                <option value="{$num}" selected>{$item}</option>
              {else}
                <option value="{$num}">{$item}</option>
              {/if}
            {/foreach}
          </select>
        </td>
        <td class="col-sm-2">第二カテゴリ</td>
        <td class="col-sm-4">
          <select name="ca_cate02" onchange="getSelectedValAndText(this);">
            {foreach name=ca_cate02 from=$opt_ca_cate02 key=num item=item}
              {if $num == $serch_item.ca_cate02}
                <option value="{$num}" selected>{$item}</option>
              {else}
                <option value="{$num}">{$item}</option>
              {/if}
            {/foreach}
          </select>
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

{form_open('/system/category_chg/' , 'name="detailForm" class="form-horizontal"')}
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>カテゴリ名</th>
                <th>親ID</th>
                <th>表示階層</th>
                <th>表示順</th>
                <th></th>
                <th></th>
            </tr>
        </thead>

        {foreach from=$list item=cate}
        <tbody>
            <tr>
                <td>
                    {$cate.ca_seq}
                </td>
                <td>
                    {$cate.ca_name}
                </td>
                <td>
                    {$cate.ca_parent}
                </td>
                <td>
                    {$cate.ca_level}
                </td>
                <td>
                    {$cate.ca_dispno}
                </td>
                <td>
                    <button type="submit" class="btn btn-success btn-xs" name="chg_uniq" value="{$cate.ca_seq}">編集</button>
                    <button type="button" class="btn btn-default btn-xs" name="del_uniq" value="{$cate.ca_seq}">削除</button>
                </td>
            </tr>
        </tbody>
        {foreachelse}
            検索結果はありませんでした。
        {/foreach}

    </table>

{form_close()}

<ul class="pagination pagination-sm">
  {$set_pagination}
</ul>


<br><br>
<hr>
{form_open('/system/category_chg/' , 'name="detailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="ca_name" class="col-sm-2 control-label">【カテゴリ名　変更】</label>
  </div>
  <div class="form-group">
    <label for="ca_name" class="col-sm-2 control-label">カテゴリ名</label>
    <div class="col-sm-7">
      {form_input('ca_name' , set_value('ca_name', $ca_name) , 'class="form-control" placeholder="カテゴリ名を入力してください。"')}
      {if form_error('ca_name')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ca_name')}</font></label>{/if}
    </div>
    <div class="col-sm-2">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">変　更</button>
    </div>
  </div>

  <!-- Button trigger modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">カテゴリ名　変更</h4>
        </div>
        <div class="modal-body">
          <p>変更しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value=catechg class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

{form_close()}

<hr>
{form_open('/system/category_chg/' , 'name="detailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="ca_name" class="col-sm-2 control-label">【カテゴリ　　削除】</label>
    <p class="col-sm-6">カテゴリの削除を行いたい場合は、システムに問合せしてください。</p>
  </div>

{form_close()}


</div>


{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
