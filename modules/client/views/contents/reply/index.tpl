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

<h4>【お問合せ　一覧】</h4>

<ul class="pagination pagination-sm">
    お問合せ件数： {$countall}件<br />
    {$set_pagination}
</ul>

{form_open('/reply/detail' , 'name="listForm" class="form-horizontal"')}
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>状態</th>
                <th>受信日付</th><br>内容</th>
                <th>お客様</th>
                <th>メールアドレス</th>
                <th>連絡先TEL</th>
                <th></th>
            </tr>
        </thead>


        {foreach from=$list item=cont name="seq"}
        <tbody>
            <tr>
                <td>
                    {$smarty.foreach.seq.iteration}
                </td>
                <td>
                    {if $cont.co_status == "0"}<font color="#ffffff" style="background-color:royalblue">[ 未開封 ]</font>
                    {elseif $cont.co_status == "1"}<font color="#ffffff" style="background-color:tomato">[ 開　封 ]</font>
                    {elseif $cont.co_status == "2"}<font color="#ffffff" style="background-color:green">[ 対応済 ]</font>
                    {else}}エラー
                    {/if}
                </td>
                <td>
                    {$cont.co_create_date}
                </td>
                <td>
                    {$cont.co_contact_name|escape}
                </td>
                <td>
                    {$cont.co_contact_mail}
                </td>
                <td>
                    {$cont.co_contact_tel}
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('listForm', '/client/reply/detail/', 'POST', '{$cont.co_seq}', 'chg_uniq');">詳　細</button>
                </td>
            </tr>
            <tr>
               <td></td>
               <td></td>
               <td colspan="5" style="width: 100px; max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {$cont.co_contact_body}
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
