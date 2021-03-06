{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>　TOP画面</h3>
</div>

<p class="bg-info">　■　現在のステータス状況</p>
{if $list.cl_status == 3}
  <button type="button" class="btn btn-info">取材中</button>
{else}
  <button type="button" class="btn btn-default">取材中</button>
{/if} -->
{if ($list.cl_status == 4) || ($list.cl_status == 9)}
  <button type="button" class="btn btn-info">編集中</button>
{else}
  <button type="button" class="btn btn-default">編集中</button>
{/if} -->
{if $list.cl_status == 5}
  <button type="button" class="btn btn-info">営業確認中</button>
{else}
  <button type="button" class="btn btn-default">営業確認中</button>
{/if} -->
{if $list.cl_status == 6}
  <button type="button" class="btn btn-info">御社確認中</button>
{else}
  <button type="button" class="btn btn-default">御社確認中</button>
{/if} -->
{if $list.cl_status == 7}
  <button type="button" class="btn btn-info">最終確認中</button>
{else}
  <button type="button" class="btn btn-default">最終確認中</button>
{/if} -->
{if $list.cl_status == 8}
  <button type="button" class="btn btn-info">掲載中</button>
{else}
  <button type="button" class="btn btn-default">掲載中</button>
{/if}　　

{if $list.cl_status == 19}
  <button type="button" class="btn btn-warning">掲載一時停止</button>
{/if}



{if $list.cl_status == 6}
<br><br><br><br>

{form_open('top/preview/' , 'name="EntrytenpoForm" class="form-horizontal"')}

  <p class="bg-info">　■　掲載前サイト確認　および　承認作業</p>

  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">プレビュー ＆ 承認</button>
  </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">掲載前サイト確認　および　承認作業</h4>
        </div>
        <div class="modal-body">
          <p>「承　認」を選択された場合は、掲載作業の準備に入ります。&hellip;</p>
          <p>「非承認」を選択された場合は、再度編集見直し作業を行います。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='preview' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

{form_close()}

{/if}


{if $list.cl_status == 8}
<br><br><br><br>
  <p class="bg-info">　■　掲載サイト確認</p>

    <a href="https://{$smarty.server.HTTP_HOST}/site/pf/{$list.cl_siteid}" target="_blank">{$list.cl_siteid}　サイト</a>

{/if}


{if $list.cl_blog_status == 0}
<br><br><br><br>
  <p class="bg-info">　■　ブログサイト確認</p>

    <a href="https://{$smarty.server.HTTP_HOST}/blog/pf/{$list.cl_siteid}" target="_blank">{$list.cl_siteid}　ブログ</a>

{/if}


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
