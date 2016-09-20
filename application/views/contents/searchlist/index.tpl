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

<ul class="pagination pagination-sm">
    検索結果： {$countall}件<br />
    {$set_pagination}
</ul>

<form class="form-horizontal" name="searchForm" method="post" action="/searchlist/">
  <table class="table table-striped table-hover">
    {foreach from=$list item=tnp}
    <tbody>
      <tr>
        <td>
          <img src="/images/{$tnp.tp_cl_siteid}/s/t_{$tnp.img}" alt="">
        </td>
        <td>
          <a href="/site/pf/{$tnp.tp_cl_siteid}">{$tnp.tp_cl_siteid}</a><br>
          {$tnp.tp_shopname|escape} :: {$tnp.tp_shopname_sub|escape}<br>
          {$tnp.tp_ovtitle}<br><br>
          〒 {$tnp.tp_zip01}-{$tnp.tp_zip02} {$tnp.tp_prefname|escape}{$tnp.tp_addr01|escape} {$tnp.tp_addr02|escape} {$tnp.tp_buil|escape}<br>
          連絡先：{$tnp.tp_mail} TEL.{$tnp.tp_tel}<br>
          アクセス：{$tnp.tp_accessinfo}
        </td>
      </tr>
    </tbody>
    {foreachelse}
      検索結果はありませんでした。
    {/foreach}

  </table>

</form>

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
