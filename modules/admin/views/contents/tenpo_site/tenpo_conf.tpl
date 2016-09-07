{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}
{* ヘッダー部分　END *}

<body>

<H3><p class="bg-info">店舗（クライアント）情報設定</p></H3>

{form_open('tenpo_site/tenpo_comp/' , 'name="EntrytenpoForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="tp_cate01" class="col-sm-3 control-label">カテゴリ１選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('tp_cate01', $opt_tp_cate01, set_value('tp_cate01', ''))}
      {if form_error('tp_cate01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('tp_cate01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_cate02" class="col-sm-3 control-label">カテゴリ２選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('tp_cate02', $opt_tp_cate02, set_value('tp_cate02', ''))}
      {if form_error('tp_cate02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('tp_cate02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_cate03" class="col-sm-3 control-label">カテゴリ３選択</label>
    <div class="col-sm-2 btn-lg">
      {form_dropdown('tp_cate03', $opt_tp_cate03, set_value('tp_cate03', ''))}
      {if form_error('tp_cate03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('tp_cate03')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_shopname" class="col-sm-3 control-label">店舗名称<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('tp_shopname', '')}
      {form_hidden('tp_shopname', set_value('tp_shopname', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_shopname_sub" class="col-sm-3 control-label">店舗名称予備</label>
    <div class="col-sm-9">
      {$shopname_sub}
      {*set_value('tp_shopname_sub', '')*}
      {form_hidden('tp_shopname_sub', set_value('tp_shopname_sub', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_url" class="col-sm-3 control-label">店舗サイトURL</label>
    <div class="col-sm-9">
      {set_value('tp_url', '')}
      {form_hidden('tp_url', set_value('tp_url', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_zip" class="col-sm-3 control-label">郵便番号<font color=red>【必須】</font></label>
    <div class="col-sm-2">
      {set_value('tp_zip01', '')} - {set_value('tp_zip02', '')}
      {form_hidden('tp_zip01', set_value('tp_zip01', ''))}
      {form_hidden('tp_zip02', set_value('tp_zip02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_pref" class="col-sm-3 control-label">都道府県<font color=red>【必須】</font></label>
    <div class="col-sm-2 btn-lg">
      {$pref_name}
      {form_hidden('tp_pref', set_value('tp_pref', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_addr01" class="col-sm-3 control-label">市区町村<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('tp_addr01', '')}
      {form_hidden('tp_addr01', set_value('tp_addr01', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_addr02" class="col-sm-3 control-label">町名・番地<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {set_value('tp_addr02', '')}
      {form_hidden('tp_addr02', set_value('tp_addr02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_buil" class="col-sm-3 control-label">ビル・マンション名など</label>
    <div class="col-sm-9">
      {set_value('tp_buil', '')}
      {form_hidden('tp_buil', set_value('tp_buil', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_tel" class="col-sm-3 control-label">電話番号</label>
    <div class="col-sm-9">
      {set_value('tp_tel', '')}
      {form_hidden('tp_tel', set_value('tp_tel', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_mail" class="col-sm-3 control-label">メールアドレス</label>
    <div class="col-sm-9">
      {set_value('tp_mail', '')}
      {form_hidden('tp_mail', set_value('tp_mail', ''))}
    </div>
  </div>

  <div class="form-group">
    <label for="tp_opentime" class="col-sm-3 control-label">営業時間</label>
    <div class="col-sm-9">
      {set_value('tp_opentime', '')}
      {form_hidden('tp_opentime', set_value('tp_opentime', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_holiday" class="col-sm-3 control-label">定休日</label>
    <div class="col-sm-9">
      {set_value('tp_holiday', '')}
      {form_hidden('tp_holiday', set_value('tp_holiday', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_since" class="col-sm-3 control-label">創業／設立日</label>
    <div class="col-sm-9">
      {set_value('tp_since', '')}
      {form_hidden('tp_since', set_value('tp_since', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_parking" class="col-sm-3 control-label">駐車場情報</label>
    <div class="col-sm-9">
      {set_value('tp_parking', '')}
      {form_hidden('tp_parking', set_value('tp_parking', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_seat" class="col-sm-3 control-label">座席情報</label>
    <div class="col-sm-9">
      {set_value('tp_seat', '')}
      {form_hidden('tp_seat', set_value('tp_seat', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_card" class="col-sm-3 control-label">カード情報</label>
    <div class="col-sm-9">
      {set_value('tp_card', '')}
      {form_hidden('tp_card', set_value('tp_card', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_access" class="col-sm-3 control-label">アクセス情報</label>
    <div class="col-sm-9">
      {set_value('tp_access', '')}
      {form_hidden('tp_access', set_value('tp_access', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_access_sub" class="col-sm-3 control-label">アクセス情報予備</label>
    <div class="col-sm-9">
      {set_value('tp_access_sub', '')}
      {form_hidden('tp_access_sub', set_value('tp_access_sub', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_contents01" class="col-sm-3 control-label">メニュー情報１</label>
    <div class="col-sm-9">
      {set_value('tp_contents01', '')}
      {form_hidden('tp_contents01', set_value('tp_contents01', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_contents02" class="col-sm-3 control-label">メニュー情報２</label>
    <div class="col-sm-9">
      {set_value('tp_contents02', '')}
      {form_hidden('tp_contents02', set_value('tp_contents02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_description" class="col-sm-3 control-label">ディスクリプション(METAタグ)</label>
    <div class="col-sm-9">
      {set_value('tp_description', '')}
      {form_hidden('tp_description', set_value('tp_description', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_keywords" class="col-sm-3 control-label">キーワード(METAタグ)</label>
    <div class="col-sm-9">
      {set_value('tp_keywords', '')}
      {form_hidden('tp_keywords', set_value('tp_keywords', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_sns01" class="col-sm-3 control-label">ＳＮＳコード１</label>
    <div class="col-sm-9">
      {set_value('tp_sns01', '')}
      {form_hidden('tp_sns01', set_value('tp_sns01', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_sns02" class="col-sm-3 control-label">ＳＮＳコード２</label>
    <div class="col-sm-9">
      {set_value('tp_sns02', '')}
      {form_hidden('tp_sns02', set_value('tp_sns02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_sns03" class="col-sm-3 control-label">ＳＮＳコード３</label>
    <div class="col-sm-9">
      {set_value('tp_sns03', '')}
      {form_hidden('tp_sns03', set_value('tp_sns03', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_sns04" class="col-sm-3 control-label">ＳＮＳコード４</label>
    <div class="col-sm-9">
      {set_value('tp_sns04', '')}
      {form_hidden('tp_sns04', set_value('tp_sns04', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_sns05" class="col-sm-3 control-label">ＳＮＳコード５</label>
    <div class="col-sm-9">
      {set_value('tp_sns05', '')}
      {form_hidden('tp_sns05', set_value('tp_sns05', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_google_map" class="col-sm-3 control-label">googleマップコード</label>
    <div class="col-sm-9">
      {set_value('tp_google_map', '')}
      {form_hidden('tp_google_map', set_value('tp_google_map', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_qrcode_site" class="col-sm-3 control-label">QRコード</label>
    <div class="col-sm-9">
      {set_value('tp_qrcode_site', '')}
      {form_hidden('tp_qrcode_site', set_value('tp_qrcode_site', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_free01" class="col-sm-3 control-label">フリー１</label>
    <div class="col-sm-9">
      {set_value('tp_free01', '')}
      {form_hidden('tp_free01', set_value('tp_free01', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_free02" class="col-sm-3 control-label">フリー２</label>
    <div class="col-sm-9">
      {set_value('tp_free02', '')}
      {form_hidden('tp_free02', set_value('tp_free02', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_free03" class="col-sm-3 control-label">フリー３</label>
    <div class="col-sm-9">
      {set_value('tp_free03', '')}
      {form_hidden('tp_free03', set_value('tp_free03', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_free04" class="col-sm-3 control-label">フリー４</label>
    <div class="col-sm-9">
      {set_value('tp_free04', '')}
      {form_hidden('tp_free04', set_value('tp_free04', ''))}
    </div>
  </div>
  <div class="form-group">
    <label for="tp_free05" class="col-sm-3 control-label">フリー５</label>
    <div class="col-sm-9">
      {set_value('tp_free05', '')}
      {form_hidden('tp_free05', set_value('tp_free05', ''))}
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
