{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}

<H3><p class="bg-info">店舗（クライアント）情報設定</p></H3>


{*form_open('entrytenpo/tenpo_pre/' , 'name="EntrytenpoForm" class="form-horizontal"  target="_blank"')*}
<form method="post" target="_blank" action="../../../preview/pf/">

  <div class="form-group">
    <div class="col-sm-offset-10 col-sm-2">
      <button type='submit' name='submit' value='preview' class="btn btn-sm btn-primary">プレビュー</button>
    </div>
  </div>

  <input type="hidden" name="en_seq" value={$list.en_seq}>
  <input type="hidden" name="ticket" value={$ticket}>

</form>
{*form_close()*}

{form_open('entrytenpo/tenpo_conf/' , 'name="EntrytenpoForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="en_cate01" class="col-sm-3 control-label">カテゴリ１選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('en_cate01', $opt_en_cate01, set_value('en_cate01', $list.en_cate01))}
      {if form_error('en_cate01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_cate01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_cate02" class="col-sm-3 control-label">カテゴリ２選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('en_cate02', $opt_en_cate02, set_value('en_cate02', $list.en_cate02))}
      {if form_error('en_cate02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_cate02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_cate03" class="col-sm-3 control-label">カテゴリ３選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('en_cate03', $opt_en_cate03, set_value('en_cate03', $list.en_cate03))}
      {if form_error('en_cate03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_cate03')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_shopname" class="col-sm-3 control-label">店舗名称<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('en_shopname' , set_value('en_shopname', $list.en_shopname) , 'class="form-control" placeholder="店舗名称を入力してください"')}
      {if form_error('en_shopname')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_shopname')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_shopname_sub" class="col-sm-3 control-label">店舗名称予備</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_shopname_sub" name="en_shopname_sub" placeholder="店舗名称予備を入力してください。max.500文字">{$list.en_shopname_sub}</textarea>
      {if form_error('en_shopname_sub')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_shopname_sub')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_url" class="col-sm-3 control-label">店舗サイトURL</label>
    <div class="col-sm-9">
      {form_input('en_url' , set_value('en_url', $list.en_url) , 'class="form-control" placeholder="店舗サイトURLを入力してください"')}
      {if form_error('en_url')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_url')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_zip" class="col-sm-3 control-label">郵便番号<font color=red>【必須】</font></label>
    <div class="col-sm-2">
      {form_input('en_zip01' , set_value('en_zip01', $list.en_zip01) , 'class="form-control" placeholder="郵便番号（3ケタ）"')}
      {if form_error('en_zip01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_zip01')}</font></label>{/if}
    </div>
    <div class="col-sm-2">
      {form_input('en_zip02' , set_value('en_zip02', $list.en_zip02) , 'class="form-control" placeholder="郵便番号（4ケタ）"')}
      {if form_error('en_zip02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_zip02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_pref" class="col-sm-3 control-label">都道府県<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('en_pref', $opt_pref, set_value('en_pref', $list.en_pref))}
      {if form_error('en_pref')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_pref')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_addr01" class="col-sm-3 control-label">市区町村<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('en_addr01' , set_value('en_addr01', $list.en_addr01) , 'class="form-control" placeholder="市区町村を入力してください"')}
      {if form_error('en_addr01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_addr01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_addr02" class="col-sm-3 control-label">町名・番地<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('en_addr02' , set_value('en_addr02', $list.en_addr02) , 'class="form-control" placeholder="町名・番地を入力してください"')}
      {if form_error('en_addr02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_addr02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_buil" class="col-sm-3 control-label">ビル・マンション名など</label>
    <div class="col-sm-9">
      {form_input('en_buil' , set_value('en_buil', $list.en_buil) , 'class="form-control" placeholder="ビル・マンション名などを入力してください"')}
      {if form_error('en_buil')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_buil')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_tel" class="col-sm-3 control-label">電話番号</label>
    <div class="col-sm-9">
      {form_input('en_tel' , set_value('en_tel', $list.en_tel) , 'class="form-control" placeholder="電話番号を入力してください"')}
      {if form_error('en_tel')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_tel')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_mail" class="col-sm-3 control-label">メールアドレス</label>
    <div class="col-sm-9">
      {form_input('en_mail' , set_value('en_mail', $list.en_mail) , 'class="form-control" placeholder="メールアドレスを入力してください"')}
      {if form_error('en_mail')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_mail')}</font></label>{/if}
    </div>
  </div>

  <div class="form-group">
    <label for="en_opentime" class="col-sm-3 control-label">営業時間</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_opentime" name="en_opentime" placeholder="営業時間を入力してください。max.500文字">{$list.en_opentime}</textarea>
      {if form_error('en_opentime')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_opentime')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_holiday" class="col-sm-3 control-label">定休日</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_holiday" name="en_holiday" placeholder="定休日を入力してください。max.500文字">{$list.en_holiday}</textarea>
      {if form_error('en_holiday')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_holiday')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_since" class="col-sm-3 control-label">創業／設立日</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_since" name="en_since" placeholder="創業／設立日を入力してください。max.500文字">{$list.en_since}</textarea>
      {if form_error('en_since')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_since')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_parking" class="col-sm-3 control-label">駐車場情報</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_parking" name="en_parking" placeholder="駐車場情報を入力してください。max.500文字">{$list.en_parking}</textarea>
      {if form_error('en_parking')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_parking')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_seat" class="col-sm-3 control-label">座席情報</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_seat" name="en_seat" placeholder="座席情報を入力してください。max.500文字">{$list.en_seat}</textarea>
      {if form_error('en_seat')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_seat')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_card" class="col-sm-3 control-label">カード情報</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_card" name="en_card" placeholder="カード情報を入力してください。max.500文字">{$list.en_seat}</textarea>
      {if form_error('en_card')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_card')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_access" class="col-sm-3 control-label">アクセス情報</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_access" name="en_access" placeholder="アクセス情報を入力してください。max.500文字">{$list.en_access}</textarea>
      {if form_error('en_access')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_access')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_access_sub" class="col-sm-3 control-label">アクセス情報予備</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_access_sub" name="en_access_sub" placeholder="アクセス情報予備を入力してください。max.500文字">{$list.en_access_sub}</textarea>
      {if form_error('en_access_sub')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_access_sub')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_contents01" class="col-sm-3 control-label">メニュー情報１</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_contents01" name="en_contents01" placeholder="メニュー情報１を入力してください。max.500文字">{$list.en_contents01}</textarea>
      {if form_error('en_contents01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_contents01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_contents02" class="col-sm-3 control-label">メニュー情報２</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_contents02" name="en_contents02" placeholder="メニュー情報２を入力してください。max.500文字">{$list.en_contents02}</textarea>
      {if form_error('en_contents02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_contents02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_description" class="col-sm-3 control-label">ディスクリプション(METAタグ)</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_description" name="en_description" placeholder="ディスクリプションを入力してください。max.500文字">{$list.en_description}</textarea>
      {if form_error('en_description')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_description')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_keywords" class="col-sm-3 control-label">キーワード(METAタグ)</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_keywords" name="en_keywords" placeholder="キーワードを入力してください。max.500文字">{$list.en_keywords}</textarea>
      {if form_error('en_keywords')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_keywords')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns01" class="col-sm-3 control-label">ＳＮＳコード１</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_sns01" name="en_sns01" placeholder="ＳＮＳコード１を入力してください。">{$list.en_sns01}</textarea>
      {if form_error('en_sns01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_sns01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns02" class="col-sm-3 control-label">ＳＮＳコード２</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_sns02" name="en_sns02" placeholder="ＳＮＳコード２を入力してください。">{$list.en_sns02}</textarea>
      {if form_error('en_sns02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_sns02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns03" class="col-sm-3 control-label">ＳＮＳコード３</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_sns03" name="en_sns03" placeholder="ＳＮＳコード３を入力してください。">{$list.en_sns03}</textarea>
      {if form_error('en_sns03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_sns03')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns04" class="col-sm-3 control-label">ＳＮＳコード４</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_sns04" name="en_sns04" placeholder="ＳＮＳコード４を入力してください。">{$list.en_sns04}</textarea>
      {if form_error('en_sns04')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_sns04')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns05" class="col-sm-3 control-label">ＳＮＳコード５</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_sns05" name="en_sns05" placeholder="ＳＮＳコード５を入力してください。">{$list.en_sns05}</textarea>
      {if form_error('en_sns05')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_sns05')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_google_map" class="col-sm-3 control-label">googleマップコード</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_google_map" name="en_google_map" placeholder="googleマップコードを入力してください。">{$list.en_google_map}</textarea>
      {if form_error('en_google_map')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_google_map')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free01" class="col-sm-3 control-label">フリー１</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free01" name="en_free01" placeholder="フリー１を入力してください。max.500文字">{$list.en_free01}</textarea>
      {if form_error('en_free01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free02" class="col-sm-3 control-label">フリー２</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free02" name="en_free02" placeholder="フリー２を入力してください。max.500文字">{$list.en_free02}</textarea>
      {if form_error('en_free02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free03" class="col-sm-3 control-label">フリー３</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free03" name="en_free03" placeholder="フリー３を入力してください。max.500文字">{$list.en_free03}</textarea>
      {if form_error('en_free03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free03')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free04" class="col-sm-3 control-label">フリー４</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free04" name="en_free04" placeholder="フリー４を入力してください。max.500文字">{$list.en_free04}</textarea>
      {if form_error('en_free04')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free04')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free05" class="col-sm-3 control-label">フリー５</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free05" name="en_free05" placeholder="フリー５を入力してください。max.500文字">{$list.en_free05}</textarea>
      {if form_error('en_free05')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free05')}</font></label>{/if}
    </div>
  </div>

  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">登録する</button>
  </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">店舗情報　登録</h4>
        </div>
        <div class="modal-body">
          <p>登録しますか。&hellip;</p>
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
