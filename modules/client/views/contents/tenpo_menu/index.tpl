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

  <form method="post" action="/client/tenpo_menu/create_menu/" enctype="multipart/form-data" name="form">

  <p class="text-right">
    <button type='submit' name='_submit' value='_new'>メニュー登録へ</button>
  </p>

  </form>

<p class="bg-info">　【 店舗メニュー 一覧 】</p>

<ul class="pagination pagination-sm">
    件数： {$countall}件<br />
    {$set_pagination}
</ul>

{form_open('/tenpo_menu/detail' , 'name="listForm" class="form-horizontal"')}
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>状態</th>
                <th>階層</th>
                <th>メニュータイトル（階層）</th>
                <th>作成＆更新日</th>
                <th></th>
            </tr>
        </thead>


        {foreach from=$list item=menu name="seq"}
        <tbody>
            <tr>
                <td>
                    {$smarty.foreach.seq.iteration}
                </td>
                <td>
                    {if $menu.mn_status == "0"}<font color="#ffffff" style="background-color:royalblue">[ 公開中 ]</font>
                    {elseif $menu.mn_status == "1"}<font color="#ffffff" style="background-color:tomato">[ 非公開 ]</font>
                    {else}}エラー
                    {/if}
                </td>
                <td>
                    {$menu.mn_level}
                </td>
                <td style="width: 700px; max-width: 700px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {$menu_name[$menu.mn_seq]|escape}
                </td>
                <td>
                    {$menu.mn_update_date}
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('listForm', '/client/tenpo_menu/detail/', 'POST', '{$menu.mn_seq}', 'chg_uniq');">編　集</button>
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
