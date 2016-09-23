{* ヘッダー部分　START *}
    {include file="../header_wysiwyg.tpl" head_index="1"}


<body>
{* ヘッダー部分　END *}

<p class="bg-info">　■　ブログ コメント一覧</p>


{form_open('blog/comment/' , 'name="blogForm" class="form-horizontal"')}

<div class="row">
  <div class="col-sm-2 col-sm-offset-1">{$set_pagination}</div>
  <div class="col-sm-2 col-sm-offset-7">登録件数： {$countall}件</div>
</div>



  <div class="form-horizontal col-sm-12">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th class="col-sm-2">日　時</th>
                <th>コメント</th>
                <th></th>
            </tr>
        </thead>

        {foreach from=$list item=bl  name="seq"}
        <tbody>
            <tr>
                <td>
                    {$smarty.foreach.seq.iteration}
                </td>
                <td>
                    {$bl.bcm_date}
                </td>
                <td>
                    {$bl.bcm_text}
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal{$smarty.foreach.seq.iteration}">削除する</button>
                </td>
            </tr>

            <!-- Button trigger modal -->
            <div class="modal fade" id="myModal{$smarty.foreach.seq.iteration}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ブログコメント　削除</h4>
                  </div>
                <div class="modal-body">
                <p>削除します。よろしいですか。&hellip;</p>
                </div>
                  <div class="modal-footer">
                    <button type='submit' name='chg_uniq' value='{$bl.bcm_seq}' class="btn btn-sm btn-primary">O  K</button>
                    <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </tbody>
        {foreachelse}
            検索結果はありませんでした。
        {/foreach}

    </table>
  </div>




{form_close()}

<!-- </form> -->


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
