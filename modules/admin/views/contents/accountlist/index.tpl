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

<h4>【アカウント検索】</h4>
{form_open('/accountlist/search/' , 'name="searchForm" class="form-horizontal"')}
  <table class="table table-hover table-bordered">
    <tbody>

      <tr>
        <td class="col-sm-2">氏　　名</td>
        <td class="col-sm-4">
          {form_input('ac_name' , set_value('ac_name', '') , 'class="form-control" placeholder="氏名を入力してください。"')}
          {if form_error('ac_name')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_name')}</font></label>{/if}
        </td>
        <td class="col-sm-2">メールアドレス</td>
        <td class="col-sm-4">
          {form_input('ac_mail' , set_value('ac_mail', '') , 'class="form-control" placeholder="メールアドレスを入力してください。"')}
          {if form_error('ac_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('ac_mail')}</font></label>{/if}
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

{form_open('/accountlist/detail/' , 'name="detailForm" class="form-horizontal"')}
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>状態</th>
                <th>Type</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th></th>
            </tr>
        </thead>


        {foreach from=$list item=ac}
        <tbody>
            <tr>
                <td>
                    {$ac.ac_seq}
                </td>
                <td>
                    {if $ac.ac_status == "0"}<font color="#ffffff" style="background-color:#008000">登録中</font>
                    {elseif $ac.ac_status == "1"}<font color="#ffffff" style="background-color:#0000ff">有　効</font>
                    {elseif $ac.ac_status == "9"}<font color="#ffffff" style="background-color:#ff6347">無　効</font>
                    {else}}エラー
                    {/if}
                </td>
                <td>
                    {if $ac.ac_type == "0"}<font color="#ffffff" style="background-color:#00ff00">Editor</font>
                    {elseif $ac.ac_type == "1"}<font color="#ffffff" style="background-color:#00bfff">Sales</font>
                    {elseif $ac.ac_type == "2"}<font color="#ffffff" style="background-color:#ff1493">Admin</font>
                    {else}}エラー
                    {/if}
                </td>
                <td>
                    {$ac.ac_name01|escape}　{$ac.ac_name02|escape}
                </td>
                <td>
                    {$ac.ac_mail}
                </td>
                <td>
                    <button type="submit" class="btn btn-success btn-xs" name="ac_uniq" value="{$ac.ac_seq}">編集</button>
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