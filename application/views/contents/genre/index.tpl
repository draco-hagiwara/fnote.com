{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}


<div id="contents" class="container">




{*ジャンルから探す*}
{section name=i loop=$list_cate01}

  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td>
          {if isset($list_cate01[i].ca_id)}<a href="/genre/genrelist/{$list_cate01[i].ca_id}/1/">【 {$list_cate01[i].ca_name} 】</a><br>{/if}
        </td>
      </tr>
          {section name=j loop=$list_cate02[i]}
      <tr>
        <td>
            {if isset($list_cate02[i][j].ca_id)}<a href="/genre/genrelist/{$list_cate02[i][j].ca_id}/2/">　■ {$list_cate02[i][j].ca_name}</a><br>{/if}
        </td>
      </tr>
      <tr>
        <td>
            {section name=k loop=$list_cate03[i][j]}
              {if isset($list_cate03[i][j][k].ca_id)}<a href="/genre/genrelist/{$list_cate03[i][j][k].ca_id}/3/">　　・ {$list_cate03[i][j][k].ca_name}</a><br>{/if}
            {/section}
        </td>
          {/section}
      </tr>
    </tbody>
  </table>
{/section}

</div>


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
