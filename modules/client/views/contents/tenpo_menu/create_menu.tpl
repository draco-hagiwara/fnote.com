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
    var fm = document.forms["menuForm"];
    fm.method = "POST";                                     // method(GET or POST)を設定する
    fm.setAttribute("value", val);                          // 選択ジャンルコード
    fm.action = "/client/tenpo_menu/create_menu/";          // action(遷移先URL)を設定する
    fm.submit();                                            // submit する
    return true;
}
</script>


<p class="bg-info">　【 店舗メニューの並び替え　＆　登録 】</p>

{form_open('/tenpo_menu/create_menu/' , 'name="menuForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="mn_seq01" class="col-sm-1 control-label">MENU 1</label>
    <div class="col-sm-3 btn-lg">
    <select name="mn_seq01" onchange="getSelectedValAndText(this);">
      {foreach name=mn_seq01 from=$opt_menu01 key=num item=item01}
        {if $num == $list.mn_seq01}
          <option value="{$num}" selected>{$item01}</option>
        {else}
          <option value="{$num}">{$item01}</option>
        {/if}
     {/foreach}
    </select>
    </div>
    <label for="mn_seq02" class="col-sm-1 control-label">MENU 2</label>
    <div class="col-sm-3 btn-lg">
    <select name="mn_seq02" onchange="getSelectedValAndText(this);">
      {foreach name=mn_seq02 from=$opt_menu02 key=num item=item01}
        {if $num == $list.mn_seq02}
          <option value="{$num}" selected>{$item01}</option>
        {else}
          <option value="{$num}">{$item01}</option>
        {/if}
     {/foreach}
    </select>
    </div>
    <label for="mn_seq03" class="col-sm-1 control-label">タイトル</label>
    <div class="col-sm-3 btn-lg">
    <select name="mn_seq03">
      {foreach name=mn_seq03 from=$opt_menu03 key=num item=item01}
        {if $num == $list.mn_seq03}
          <option value="{$num}" selected>{$item01}</option>
        {else}
          <option value="{$num}">{$item01}</option>
        {/if}
     {/foreach}
    </select>
    </div>
  </div>


  <div class="form-group">
    <div class="col-sm-offset-1 col-sm-6">
      <ul class="sortable">
        {foreach name=ca_cate01 from=$sort_menu01 key=num item=item}
          <li id="{$num}">{$item}</li>
        {/foreach}
      </ul>
      <input type="hidden" id="result01" name="result01" />
      <button id="sort">並び替え決定</button>
      <br>※移動させたい項目をドラッグして、移動先でドロップしてください。<br>表示が変わったことを確認して「並び替え決定」ボタンを押下してください。
    </div>
    <div class="col-sm-offset-2 col-sm-2">
      <ul class="sortable02">
        {foreach name=ca_cate02 from=$sort_menu02 key=num item=item}
          <li id="{$num}">{$item}</li>
        {/foreach}
      </ul>
      <input type="hidden" id="result02" name="result02" />
      {*<button id="sort">並び替え決定</button>*}
    </div>
    <div class="col-sm-offset-2 col-sm-2">
      <ul class="sortable03">
        {foreach name=ca_cate03 from=$sort_menu03 key=num item=item}
          <li id="{$num}">{$item}</li>
        {/foreach}
      </ul>
      <input type="hidden" id="result03" name="result03" />
      {*<button id="sort">並び替え決定</button>*}
    </div>
  </div>

  <br><br><br>
  <div class="form-group">
    <label for="nm_name" class="col-sm-2 control-label">MENU 1 に追加</label>
    <div class="col-sm-4">
      {form_input('mn_name01' , set_value('mn_name01', '') , 'class="form-control" placeholder="追加する MENU1 を入力してください"')}
      {if $err_mess01 != NULL}<span class="label label-danger">Error : </span><label><font color=red>{$err_mess01}</font></label>{/if}
    </div>
    <div class="col-sm-6">
      <button type="submit" name="new" value="menu01">登録</button>
    </div>
  </div>
  <div class="form-group">
    <label for="mn_name02" class="col-sm-2 control-label">MENU 2 に追加</label>
    <div class="col-sm-4">
      {form_input('mn_name02' , set_value('mn_name02', '') , 'class="form-control" placeholder="追加する MENU2 を入力してください"')}
      {if $err_mess02 != NULL}<span class="label label-danger">Error : </span><label><font color=red>{$err_mess02}</font></label>{/if}
    </div>
    <div class="col-sm-6">
      <button type="submit" name="new" value="menu02">登録</button>
      ※必ず「MENU 1」を選択してから「登録」ボタンを押してください。
    </div>
  </div>
  <div class="form-group">
    <label for="mn_name03" class="col-sm-2 control-label">タイトル に追加</label>
    <div class="col-sm-4">
      {form_input('mn_name03' , set_value('mn_name03', '') , 'class="form-control" placeholder="追加する タイトル を入力してください"')}
      {if $err_mess03 != NULL}<span class="label label-danger">Error : </span><label><font color=red>{$err_mess03}</font></label>{/if}
    </div>
    <div class="col-sm-6">
      <button type="submit" name="new" value="menu03">登録</button>
      ※必ず「MENU 1」と「MENU 2」を選択してから「登録」ボタンを押してください。
    </div>
  </div>






{form_close()}
<!-- </form> -->



<script>
$(function() {
    $(".sortable").sortable();
    $(".sortable").disableSelection();
    $("#sort").click(function() {
        var result = $(".sortable").sortable("toArray");
        $("#result01").val(result);
        $("form").submit();
    });
});

$(function() {
    $(".sortable02").sortable();
    $(".sortable02").disableSelection();
    $("#sort").click(function() {
        var result = $(".sortable02").sortable("toArray");
        $("#result02").val(result);
        $("form").submit();
    });
});

$(function() {
    $(".sortable03").sortable();
    $(".sortable03").disableSelection();
    $("#sort").click(function() {
        var result = $(".sortable03").sortable("toArray");
        $("#result03").val(result);
        $("form").submit();
    });
});
</script>



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
