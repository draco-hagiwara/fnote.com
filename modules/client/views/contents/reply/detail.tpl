{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>問合せ情報　確認</h3>
</div>

{form_open('/reply/comp/' , 'name="clientDetailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">受信日付</label>
    <div class="col-sm-8">
      {$list.co_create_date}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">お客様</label>
    <div class="col-sm-8">
      {$list.co_contact_name}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">メールアドレス</label>
    <div class="col-sm-8">
      {$list.co_contact_mail}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">連絡先TEL</label>
    <div class="col-sm-8">
      {$list.co_contact_tel}
    </div>
  </div>
  <div class="form-group">
    <label for="cl_company" class="col-sm-4 control-label">内容</label>
    <div class="col-sm-8">
      {$list.co_contact_body}
    </div>
  </div>

{if $co_status != 2}
  {form_hidden('co_seq', $list.co_seq)}

  <br><br>
  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">対 応 済</button>
  </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">問合せ内容　確認</h4>
        </div>
        <div class="modal-body">
          <p>問合せ確認ステータスを「対応済」に変更します。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='submit' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


{form_close()}
<!-- </form> -->

{/if}

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
