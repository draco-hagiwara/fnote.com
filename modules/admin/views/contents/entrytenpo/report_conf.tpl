{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}
{* ヘッダー部分　END *}

<body>

<H3><p class="bg-info">お店（クライアント）情報設定</p></H3>

{form_open('entrytenpo/tenpo_comp/' , 'name="EntrytenpoForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="en_cate01" class="col-sm-3 control-label">カテゴリ１選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('en_cate01', $opt_en_cate01, set_value('en_cate01', ''))}
      {if form_error('en_cate01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_cate01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_cate02" class="col-sm-3 control-label">カテゴリ２選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('en_cate02', $opt_en_cate02, set_value('en_cate02', ''))}
      {if form_error('en_cate02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_cate02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_cate03" class="col-sm-3 control-label">カテゴリ３選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('en_cate03', $opt_en_cate03, set_value('en_cate03', ''))}
      {if form_error('en_cate03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_cate03')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_shopname" class="col-sm-3 control-label">店舗名称<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('en_shopname', '')}
      {form_hidden('en_shopname', set_value('en_shopname', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_shopname_sub" class="col-sm-3 control-label">店舗名称予備</label>
    <div class="col-sm-9">
      {$shopname_sub}
      {*set_value('en_shopname_sub', '')*}
      {form_hidden('en_shopname_sub', set_value('en_shopname_sub', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_url" class="col-sm-3 control-label">店舗サイトURL</label>
    <div class="col-sm-9">
      {set_value('en_url', '')}
      {form_hidden('en_url', set_value('en_url', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_zip" class="col-sm-3 control-label">郵便番号<font color=red>【必須】</font></label>
    <div class="col-sm-2">
      {set_value('en_zip01', '')} - {set_value('en_zip02', '')}
      {form_hidden('en_zip01', set_value('en_zip01', ''))}
      {form_hidden('en_zip02', set_value('en_zip02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_pref" class="col-sm-3 control-label">都道府県<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {$pref_name}
      {form_hidden('en_pref', set_value('en_pref', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_addr01" class="col-sm-3 control-label">市区町村<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('en_addr01', '')}
      {form_hidden('en_addr01', set_value('en_addr01', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_addr02" class="col-sm-3 control-label">町名・番地<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('en_addr02', '')}
      {form_hidden('en_addr02', set_value('en_addr02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_buil" class="col-sm-3 control-label">ビル・マンション名など</label>
    <div class="col-sm-9">
      {set_value('en_buil', '')}
      {form_hidden('en_buil', set_value('en_buil', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_tel" class="col-sm-3 control-label">電話番号</label>
    <div class="col-sm-9">
      {set_value('en_tel', '')}
      {form_hidden('en_tel', set_value('en_tel', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_mail" class="col-sm-3 control-label">メールアドレス</label>
    <div class="col-sm-9">
      {set_value('en_mail', '')}
      {form_hidden('en_mail', set_value('en_mail', ''))}
    </div>
  </div>

  <div class="form-group">
    <label for="en_opentime" class="col-sm-3 control-label">営業時間</label>
    <div class="col-sm-9">
      {set_value('en_opentime', '')}
      {form_hidden('en_opentime', set_value('en_opentime', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_holiday" class="col-sm-3 control-label">定休日</label>
    <div class="col-sm-9">
      {set_value('en_holiday', '')}
      {form_hidden('en_holiday', set_value('en_holiday', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_since" class="col-sm-3 control-label">創業／設立日</label>
    <div class="col-sm-9">
      {set_value('en_since', '')}
      {form_hidden('en_since', set_value('en_since', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_parking" class="col-sm-3 control-label">駐車場情報</label>
    <div class="col-sm-9">
      {set_value('en_parking', '')}
      {form_hidden('en_parking', set_value('en_parking', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_seat" class="col-sm-3 control-label">座席情報</label>
    <div class="col-sm-9">
      {set_value('en_seat', '')}
      {form_hidden('en_seat', set_value('en_seat', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_card" class="col-sm-3 control-label">カード情報</label>
    <div class="col-sm-9">
      {set_value('en_card', '')}
      {form_hidden('en_card', set_value('en_card', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_access" class="col-sm-3 control-label">アクセス情報</label>
    <div class="col-sm-9">
      {set_value('en_access', '')}
      {form_hidden('en_access', set_value('en_access', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_access_sub" class="col-sm-3 control-label">アクセス情報予備</label>
    <div class="col-sm-9">
      {set_value('en_access_sub', '')}
      {form_hidden('en_access_sub', set_value('en_access_sub', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_contents01" class="col-sm-3 control-label">メニュー情報１</label>
    <div class="col-sm-9">
      {set_value('en_contents01', '')}
      {form_hidden('en_contents01', set_value('en_contents01', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_contents02" class="col-sm-3 control-label">メニュー情報２</label>
    <div class="col-sm-9">
      {set_value('en_contents02', '')}
      {form_hidden('en_contents02', set_value('en_contents02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_description" class="col-sm-3 control-label">ディスクリプション(METAタグ)</label>
    <div class="col-sm-9">
      {set_value('en_description', '')}
      {form_hidden('en_description', set_value('en_description', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_keywords" class="col-sm-3 control-label">キーワード(METAタグ)</label>
    <div class="col-sm-9">
      {set_value('en_keywords', '')}
      {form_hidden('en_keywords', set_value('en_keywords', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns01" class="col-sm-3 control-label">ＳＮＳコード１</label>
    <div class="col-sm-9">
      {set_value('en_sns01', '')}
      {form_hidden('en_sns01', set_value('en_sns01', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns02" class="col-sm-3 control-label">ＳＮＳコード２</label>
    <div class="col-sm-9">
      {set_value('en_sns02', '')}
      {form_hidden('en_sns02', set_value('en_sns02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns03" class="col-sm-3 control-label">ＳＮＳコード３</label>
    <div class="col-sm-9">
      {set_value('en_sns03', '')}
      {form_hidden('en_sns03', set_value('en_sns03', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns04" class="col-sm-3 control-label">ＳＮＳコード４</label>
    <div class="col-sm-9">
      {set_value('en_sns04', '')}
      {form_hidden('en_sns04', set_value('en_sns04', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_sns05" class="col-sm-3 control-label">ＳＮＳコード５</label>
    <div class="col-sm-9">
      {set_value('en_sns05', '')}
      {form_hidden('en_sns05', set_value('en_sns05', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free01" class="col-sm-3 control-label">フリー１</label>
    <div class="col-sm-9">
      {set_value('en_free01', '')}
      {form_hidden('en_free01', set_value('en_free01', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free02" class="col-sm-3 control-label">フリー２</label>
    <div class="col-sm-9">
      {set_value('en_free02', '')}
      {form_hidden('en_free02', set_value('en_free02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free03" class="col-sm-3 control-label">フリー３</label>
    <div class="col-sm-9">
      {set_value('en_free03', '')}
      {form_hidden('en_free03', set_value('en_free03', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free04" class="col-sm-3 control-label">フリー４</label>
    <div class="col-sm-9">
      {set_value('en_free04', '')}
      {form_hidden('en_free04', set_value('en_free04', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free05" class="col-sm-3 control-label">フリー５</label>
    <div class="col-sm-9">
      {set_value('en_free05', '')}
      {form_hidden('en_free05', set_value('en_free05', ''))}
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
      {$attr['name'] = '_back'}
      {$attr['type'] = 'submit'}
      {$attr['value'] = '_back'}
      {form_button($attr , '戻　　る' , 'class="btn btn-default"')}

      {$attr['name'] = 'submit'}
      {$attr['type'] = 'submit'}
      {form_button($attr , '確　　認' , 'class="btn btn-default"')}
    </div>
  </div>

{form_close()}


<!-- </form> -->


{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
