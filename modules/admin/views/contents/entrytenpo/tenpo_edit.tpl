{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}

<body>
{* ヘッダー部分　END *}


<script type="text/javascript">
/*
 * select オブジェクトの選択されている値と
 * 表示テキストを取得する
 */
function getSelectedValAndText(obj)
{
    var val = obj.options[obj.selectedIndex].value;         // 値
    var txt = obj.options[obj.selectedIndex].text;          // 表示テキスト

    // 値とテキストを連結してリターン
    console.log(val);
    console.log(txt);


    // サブミットするフォームを取得
    var fm = document.forms["EntryForm"];
    fm.method = "POST";                                     // method(GET or POST)を設定する
    fm.setAttribute("value", val);                          // 選択ジャンルコード
    fm.action = "/admin/entrytenpo/tenpo_cate/";            // action(遷移先URL)を設定する
    fm.submit();                                            // submit する
    return true;
}
</script>


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

function open_catelist() {
    window.open("about:blank","categorylist","width=950,height=650,scrollbars=yes");
    var form = document.catelistForm;
    form.target = "categorylist";
    form.method = "post";
    form.action = "/admin/entrytenpo/cate_list/";
    form.submit();
}
// -->
</script>


<H3><p class="bg-info">店舗（クライアント）情報設定</p></H3>

<form method="post" target="_blank" action="../../../preview/pf/">

  <div class="form-group">
    <div class="col-sm-offset-10 col-sm-2">
      <button type='submit' name='_submit' value='preview' class="btn btn-sm btn-primary">プレビュー</button>(一時保存後)
    </div>
  </div>

  <input type="hidden" name="en_seq" value={$list.en_seq}>
  <input type="hidden" name="ticket" value={$ticket}>

</form>

<br><br>
{form_open('entrytenpo/tenpo_conf/' , 'name="catelistForm" class="form-horizontal"')}
  <div class="form-group">
    <label for="en_cate" class="col-sm-3 control-label">カテゴリ選択<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      <button type='submit' name='_submit' value='gdlist' class="btn btn-sm btn-info" onclick="open_catelist();">カテゴリ一覧を表示</button>
      : カテゴリ番号（0x0x0x,[0-9a-z]）を入力してください。複数入力する場合は「,(カンマ)」で区切ってください。
    </div><br>
  </div>
</form>


{form_open('entrytenpo/tenpo_conf/' , 'name="EntryForm" class="form-horizontal"')}

  <div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
      {form_input('en_cate' , set_value('en_cate', $list.en_cate) , 'class="form-control" placeholder="カテゴリ番号（0x0x0x）を入力してください。複数入力する場合は「,(カンマ)」で区切ってください。max.50"')}
      {if form_error('en_cate')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_cate')}</font></label>{/if}
    </div>
  </div>
  {if !form_error('en_cate')}
  <div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
          {foreach name=cate_list from=$cate_list item=item}
            {$item}<br>
        {/foreach}
    </div>
  </div>
  {/if}


  <div class="form-group">
    <label for="en_shopname" class="col-sm-3 control-label">店舗名称<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('en_shopname' , set_value('en_shopname', $list.en_shopname) , 'class="form-control" placeholder="店舗名称を入力してください。 max.100文字"')}
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
      {form_input('en_url' , set_value('en_url', $list.en_url) , 'class="form-control" placeholder="店舗サイトURLを入力してください。 http(s)://～"')}
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
      {form_input('en_addr01' , set_value('en_addr01', $list.en_addr01) , 'class="form-control" placeholder="市区町村を入力してください。 max.100文字"')}
      {if form_error('en_addr01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_addr01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_addr02" class="col-sm-3 control-label">町名・番地<font color=red>【必須】</font></label>
    <div class="col-sm-9">
      {form_input('en_addr02' , set_value('en_addr02', $list.en_addr02) , 'class="form-control" placeholder="町名・番地を入力してください。 max.100文字"')}
      {if form_error('en_addr02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_addr02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_buil" class="col-sm-3 control-label">ビル・マンション名など</label>
    <div class="col-sm-9">
      {form_input('en_buil' , set_value('en_buil', $list.en_buil) , 'class="form-control" placeholder="ビル・マンション名などを入力してください。 max.100文字"')}
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
    <label for="en_eigyou" class="col-sm-3 control-label">営業時間</label>
    <div class="col-sm-9">
      {form_checkbox('eigyo1[]','0',$eigyo_chk[0][0])}月
      {form_checkbox('eigyo1[]','1',$eigyo_chk[0][1])}火
      {form_checkbox('eigyo1[]','2',$eigyo_chk[0][2])}水
      {form_checkbox('eigyo1[]','3',$eigyo_chk[0][3])}木
      {form_checkbox('eigyo1[]','4',$eigyo_chk[0][4])}金
      {form_checkbox('eigyo1[]','5',$eigyo_chk[0][5])}土
      {form_checkbox('eigyo1[]','6',$eigyo_chk[0][6])}日
      <br>
      <select name="eigyo_time11">
        {foreach name=eigyo_time11 from=$opt_time_h key=num item=item01}
          {if $item01 == $eigyo_time[0][0][0]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time12">
        {foreach name=eigyo_time12 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[0][0][1]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分 ～
      <select name="eigyo_time21">
        {foreach name=eigyo_time21 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[0][0][2]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time22">
        {foreach name=eigyo_time22 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[0][0][3]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分
&nbsp;&emsp;&emsp;&emsp;
      <select name="eigyo_time31">
        {foreach name=eigyo_time31 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[0][0][4]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time32">
        {foreach name=eigyo_time32 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[0][0][5]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分 ～
      <select name="eigyo_time41">
        {foreach name=eigyo_time41 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[0][0][6]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time42">
        {foreach name=eigyo_time42 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[0][0][7]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分
    </div>

    <div class="col-sm-9  col-sm-offset-3">
      {form_checkbox('eigyo2[]','0',$eigyo_chk[1][0])}月
      {form_checkbox('eigyo2[]','1',$eigyo_chk[1][1])}火
      {form_checkbox('eigyo2[]','2',$eigyo_chk[1][2])}水
      {form_checkbox('eigyo2[]','3',$eigyo_chk[1][3])}木
      {form_checkbox('eigyo2[]','4',$eigyo_chk[1][4])}金
      {form_checkbox('eigyo2[]','5',$eigyo_chk[1][5])}土
      {form_checkbox('eigyo2[]','6',$eigyo_chk[1][6])}日
      <br>
      <select name="eigyo_time51">
        {foreach name=eigyo_time51 from=$opt_time_h key=num item=item01}
          {if $item01 == $eigyo_time[1][0][0]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time52">
        {foreach name=eigyo_time52 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[1][0][1]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分 ～
      <select name="eigyo_time61">
        {foreach name=eigyo_time61 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[1][0][2]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time62">
        {foreach name=eigyo_time62 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[1][0][3]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分
&nbsp;&emsp;&emsp;&emsp;
      <select name="eigyo_time71">
        {foreach name=eigyo_time71 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[1][0][4]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time72">
        {foreach name=eigyo_time72 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[1][0][5]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分 ～
      <select name="eigyo_time81">
        {foreach name=eigyo_time81 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[1][0][6]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time82">
        {foreach name=eigyo_time82 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[1][0][7]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分
    </div>

    <div class="col-sm-9  col-sm-offset-3">
      {form_checkbox('eigyo3[]','0',$eigyo_chk[2][0])}月
      {form_checkbox('eigyo3[]','1',$eigyo_chk[2][1])}火
      {form_checkbox('eigyo3[]','2',$eigyo_chk[2][2])}水
      {form_checkbox('eigyo3[]','3',$eigyo_chk[2][3])}木
      {form_checkbox('eigyo3[]','4',$eigyo_chk[2][4])}金
      {form_checkbox('eigyo3[]','5',$eigyo_chk[2][5])}土
      {form_checkbox('eigyo3[]','6',$eigyo_chk[2][6])}日
      <br>
      <select name="eigyo_time91">
        {foreach name=eigyo_time91 from=$opt_time_h key=num item=item01}
          {if $item01 == $eigyo_time[2][0][0]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time92">
        {foreach name=eigyo_time92 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[2][0][1]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分 ～
      <select name="eigyo_time101">
        {foreach name=eigyo_time101 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[2][0][2]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time102">
        {foreach name=eigyo_time102 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[2][0][3]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分
&nbsp;&emsp;&emsp;&emsp;
      <select name="eigyo_time111">
        {foreach name=eigyo_time111 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[2][0][4]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time112">
        {foreach name=eigyo_time112 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[2][0][5]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分 ～
      <select name="eigyo_time121">
        {foreach name=eigyo_time121 from=$opt_time_h key=num item=item01}
          {if $num == $eigyo_time[2][0][6]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>時
      <select name="eigyo_time122">
        {foreach name=eigyo_time122 from=$opt_time_m key=num item=item01}
          {if $num == $eigyo_time[2][0][7]}
            <option value="{$num}" selected>{$item01}</option>
          {else}
            <option value="{$num}">{$item01}</option>
          {/if}
        {/foreach}
      </select>分
    </div>
  </div>
  <div class="form-group">
    <label for="en_opentime" class="col-sm-3 control-label">営業時間 補足入力</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_opentime" name="en_opentime" placeholder="営業時間を入力してください。max.1000文字">{$list.en_opentime}</textarea>
      {if form_error('en_opentime')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_opentime')}</font></label>{/if}
    </div>
  </div>

  <div class="form-group">
    <label for="en_eigyou" class="col-sm-3 control-label">定休日</label>
    <div class="col-sm-9">
      {form_checkbox('closed[]','0',$closed_chk[0][0])}月
      {form_checkbox('closed[]','1',$closed_chk[0][1])}火
      {form_checkbox('closed[]','2',$closed_chk[0][2])}水
      {form_checkbox('closed[]','3',$closed_chk[0][3])}木
      {form_checkbox('closed[]','4',$closed_chk[0][4])}金
      {form_checkbox('closed[]','5',$closed_chk[0][5])}土
      {form_checkbox('closed[]','6',$closed_chk[0][6])}日
      {form_checkbox('closed[]','7',$closed_chk[0][7])}祝日
    </div>
  </div>

  <div class="form-group">
    <label for="en_holiday" class="col-sm-3 control-label">定休日 補足入力</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_holiday" name="en_holiday" placeholder="定休日を入力してください。max.1000文字">{$list.en_holiday}</textarea>
      {if form_error('en_holiday')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_holiday')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_since" class="col-sm-3 control-label">創業／設立日</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_since" name="en_since" placeholder="創業／設立日を入力してください。max.200文字">{$list.en_since}</textarea>
      {if form_error('en_since')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_since')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_parking" class="col-sm-3 control-label">駐車場情報</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_parking" name="en_parking" placeholder="駐車場情報を入力してください。max.200文字">{$list.en_parking}</textarea>
      {if form_error('en_parking')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_parking')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_seat" class="col-sm-3 control-label">座席情報</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_seat" name="en_seat" placeholder="座席情報を入力してください。max.1000文字">{$list.en_seat}</textarea>
      {if form_error('en_seat')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_seat')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_card" class="col-sm-3 control-label">カード情報</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_card" name="en_card" placeholder="カード情報を入力してください。max.1000文字">{$list.en_seat}</textarea>
      {if form_error('en_card')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_card')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_access" class="col-sm-3 control-label">アクセス情報</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_access" name="en_access" placeholder="アクセス情報を入力してください。max.1000文字">{$list.en_access}</textarea>
      {if form_error('en_access')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_access')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_access_sub" class="col-sm-3 control-label">アクセス情報予備</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_access_sub" name="en_access_sub" placeholder="アクセス情報予備を入力してください。max.1000文字">{$list.en_access_sub}</textarea>
      {if form_error('en_access_sub')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_access_sub')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_contents01" class="col-sm-3 control-label">メニュー情報１</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_contents01" name="en_contents01" placeholder="メニュー情報１を入力してください。max.1000文字">{$list.en_contents01}</textarea>
      {if form_error('en_contents01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_contents01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_contents02" class="col-sm-3 control-label">メニュー情報２</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_contents02" name="en_contents02" placeholder="メニュー情報２を入力してください。max.1000文字">{$list.en_contents02}</textarea>
      {if form_error('en_contents02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_contents02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_description" class="col-sm-3 control-label">ディスクリプション(METAタグ)</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_description" name="en_description" placeholder="ディスクリプションを入力してください。max.1000文字">{$list.en_description}</textarea>
      {if form_error('en_description')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_description')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_keywords" class="col-sm-3 control-label">キーワード(METAタグ)</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_keywords" name="en_keywords" placeholder="キーワードを入力してください。max.1000文字">{$list.en_keywords}</textarea>
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
    <label for="en_qrcode_site" class="col-sm-3 control-label">QRコード</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_qrcode_site" name="en_qrcode_site" placeholder="googleマップコードを入力してください。">{$list.en_qrcode_site}</textarea>
      {if form_error('en_qrcode_site')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_qrcode_site')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free01" class="col-sm-3 control-label">フリー１</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free01" name="en_free01" placeholder="フリー１を入力してください。max.1000文字">{$list.en_free01}</textarea>
      {if form_error('en_free01')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free01')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free02" class="col-sm-3 control-label">フリー２</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free02" name="en_free02" placeholder="フリー２を入力してください。max.1000文字">{$list.en_free02}</textarea>
      {if form_error('en_free02')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free02')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free03" class="col-sm-3 control-label">フリー３</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free03" name="en_free03" placeholder="フリー３を入力してください。max.1000文字">{$list.en_free03}</textarea>
      {if form_error('en_free03')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free03')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free04" class="col-sm-3 control-label">フリー４</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free04" name="en_free04" placeholder="フリー４を入力してください。max.1000文字">{$list.en_free04}</textarea>
      {if form_error('en_free04')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free04')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="en_free05" class="col-sm-3 control-label">フリー５</label>
    <div class="col-sm-9">
      <textarea class="form-control input-sm" id="en_free05" name="en_free05" placeholder="フリー５を入力してください。max.1000文字">{$list.en_free05}</textarea>
      {if form_error('en_free05')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('en_free05')}</font></label>{/if}
    </div>
  </div>

  <input type="hidden" name="en_seq"    value={$list.en_seq}>
  <input type="hidden" name="en_cl_seq" value={$list.en_cl_seq}>
  <input type="hidden" name="ticket"    value={$ticket}>

  <!-- Button trigger modal -->
  <div class="row">
    <div class="col-sm-3 col-sm-offset-3">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">登録 & 更新する</button>
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">一時保存</button>
    </div>
    <div class="col-sm-2 col-sm-offset-4">
      <button type="button" class="btn btn-primary btn-sm" onclick="fmSubmit('EntryForm', '/admin/entrytenpo/report_edit/', 'POST', '{$list.en_cl_seq}', 'chg_uniq');">記事本文</button>
      <button type="button" class="btn btn-primary btn-sm" onclick="fmSubmit('EntryForm', '/admin/gallery/gd_list/', 'POST', '{$list.en_cl_seq}', 'chg_uniq');">画像管理</button>
    </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">店舗情報　登録 & 更新</h4>
        </div>
        <div class="modal-body">
          <p>登録 & 更新しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='save' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal fade" id="myModal02" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">店舗情報　一時保存</h4>
        </div>
        <div class="modal-body">
          <p>一時保存された内容がプレビュー表示されます。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='_submit' value='preview' class="btn btn-sm btn-primary">O  K</button>
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
