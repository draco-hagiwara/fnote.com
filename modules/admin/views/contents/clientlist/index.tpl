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

<h4>【クライアント検索】</h4>
{form_open('/clientlist/search/' , 'name="searchForm" class="form-horizontal"')}
  <table class="table table-hover table-bordered">
    <tbody>
      <tr>
        <td class="col-sm-2">サイトID</td>
        <td class="col-sm-4">
          {form_input('cl_siteid' , set_value('cl_siteid', '') , 'class="form-control" placeholder="サイトIDを入力してください。"')}
          {if form_error('cl_siteid')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_siteid')}</font></label>{/if}
        </td>
        <td class="col-sm-2">会社名</td>
        <td class="col-sm-4">
          {form_input('cl_company' , set_value('cl_company', '') , 'class="form-control" placeholder="会社名を入力してください。"')}
          {if form_error('cl_company')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_company')}</font></label>{/if}
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

{form_open('/clientlist/detail/' , 'name="detailForm" class="form-horizontal"')}
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>状態</th>
                <th>会社名</th>
                <th>サイトID</th>
                <th>担当営業</th>
                <th>担当編集</th>
                <th>管理者</th>
                <th></th>
            </tr>
        </thead>


        {foreach from=$list item=cl}
        <tbody>
            <tr>
                <td>
                    {$cl.cl_seq}
                </td>
                <td>
                    {if $cl.cl_status == "0"}<font color="#ffffff" style="background-color:royalblue">[ 登録中 ]</font>
                    {elseif $cl.cl_status == "1"}<font color="#ffffff" style="background-color:deeppink">[ 審　査 ]</font>
                    {elseif $cl.cl_status == "2"}<font color="#ffffff" style="background-color:royalblue">[ 受　注 ]</font>
                    {elseif $cl.cl_status == "3"}<font color="#ffffff" style="background-color:royalblue">[ 取材中 ]</font>
                    {elseif $cl.cl_status == "4"}<font color="#ffffff" style="background-color:royalblue">[ 編集中 ]</font>
                    {elseif $cl.cl_status == "5"}<font color="#ffffff" style="background-color:deeppink">[ 営業確認 ]</font>
                    {elseif $cl.cl_status == "6"}<font color="#ffffff" style="background-color:royalblue">[ クライアント確認 ]</font>
                    {elseif $cl.cl_status == "7"}<font color="#ffffff" style="background-color:deeppink">[ 編集最終確認 ]</font>
                    {elseif $cl.cl_status == "8"}<font color="#ffffff" style="background-color:green">[ 掲載中 ]</font>
                    {elseif $cl.cl_status == "9"}<font color="#ffffff" style="background-color:deeppink">[ 再編集 ]</font>
                    {elseif $cl.cl_status == "19"}<font color="#ffffff" style="background-color:gray">[ 一時停止 ]</font>
                    {elseif $cl.cl_status == "20"}<font color="#ffffff" style="background-color:gray">[ 解　約 ]</font>
                    {else}}エラー
                    {/if}
                </td>
                <td>
                    {$cl.cl_company|escape}
                </td>
                <td>
                    {if $cl.cl_status == "8"}
                        <a href="https://{$smarty.server.HTTP_HOST}/site/pf/{$cl.cl_siteid}" target="_blank">{$cl.cl_siteid}</a>
                    {else}{$cl.cl_siteid}
                    {/if}
                </td>
                <td>
                    {$cl.salsename01|escape} {$cl.salsename02|escape}
                </td>
                <td>
                    {$cl.editorname01|escape} {$cl.editorname02|escape}
                </td>
                <td>
                    {$cl.adminname01|escape} {$cl.adminname02|escape}
                </td>
                <td>
                    {if $smarty.session.a_memType!=1}{if $cl.cl_status >= "3" && $cl.cl_status <= "9"}
                    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/admin/tenpo_site/tenpo_edit/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">店舗</button>
                    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/admin/tenpo_interview/report_edit/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">記事</button>
                    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/admin/tenpo_good/edit/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">こだわり</button>
                    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/client/login/adminlogin/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">client</button>
                    {else}
                    <button type="button" class="btn btn-default btn-xs");">店舗</button>
                    <button type="button" class="btn btn-default btn-xs");">記事</button>
                    <button type="button" class="btn btn-default btn-xs");">こだわり</button>
                    <button type="button" class="btn btn-default btn-xs");">client</button>
                    {/if}{/if}
                    {if $cl.cl_status >= "3" && $cl.cl_status <= "9"}
                    <button type="button" class="btn btn-warning btn-xs" onclick="fmSubmit('detailForm', '/admin/gallery/gd_list/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">画像</button>
                    {else}
                    <button type="button" class="btn btn-default btn-xs");">画像</button>
                    {/if}
                    {if $smarty.session.a_memType!=0}
                    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/admin/clientlist/detail/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">編集</button>
                    {/if}
                    {if $smarty.session.a_memType==1 && $cl.cl_status == "5"}
                    <button type="button" class="btn btn-primary btn-xs" onclick="fmSubmit('detailForm', '/admin/tenpo_interview/report_pre/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">営業承認</button>
                    {/if}
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
