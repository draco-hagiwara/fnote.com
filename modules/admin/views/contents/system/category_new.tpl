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
    var fm = document.forms["cateForm"];
    fm.method = "POST";                                     // method(GET or POST)を設定する
    fm.setAttribute("value", val);                          // 選択ジャンルコード
    fm.action = "/admin/system/category_new/";              // action(遷移先URL)を設定する
    fm.submit();                                            // submit する
    return true;
}
</script>






<div class="jumbotron">
  <h3>カテゴリ 並び替え　＆　登録　　<span class="label label-danger">システム</span></h3>
</div>

{form_open('/system/category_new/' , 'name="cateForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="ca_cate01" class="col-sm-1 control-label">カテゴリ１</label>
    <div class="col-sm-3 btn-lg">
    <select name="ca_cate01" onchange="getSelectedValAndText(this);">
      {foreach name=ca_cate01 from=$opt_ca_cate01 key=num item=item01}
        {if $num == $list.ca_cate01}
          <option value="{$num}" selected>{$item01}</option>
        {else}
          <option value="{$num}">{$item01}</option>
        {/if}
     {/foreach}
    </select>
    </div>
    <label for="ca_cate02" class="col-sm-1 control-label">カテゴリ２</label>
    <div class="col-sm-3 btn-lg">
    <select name="ca_cate02" onchange="getSelectedValAndText(this);">
      {foreach name=ca_cate02 from=$opt_ca_cate02 key=num item=item01}
        {if $num == $list.ca_cate02}
          <option value="{$num}" selected>{$item01}</option>
        {else}
          <option value="{$num}">{$item01}</option>
        {/if}
     {/foreach}
    </select>
    </div>
    <label for="ca_cate03" class="col-sm-1 control-label">カテゴリ３</label>
    <div class="col-sm-3 btn-lg">
    <select name="ca_cate03">
      {foreach name=ca_cate03 from=$opt_ca_cate03 key=num item=item01}
        {if $num == $list.ca_cate03}
          <option value="{$num}" selected>{$item01}</option>
        {else}
          <option value="{$num}">{$item01}</option>
        {/if}
     {/foreach}
    </select>
    </div>
  </div>


  <div class="form-group">
    <div class="col-sm-offset-1 col-sm-2">
      <ul class="sortable">
        {foreach name=ca_cate01 from=$opt_ca_cate01 key=num item=item}
          <li id="{$num}">{$item}</li>
        {/foreach}
      </ul>
      <input type="hidden" id="result01" name="result01" />
      <button id="sort">並び替え決定</button>
    </div>
    <div class="col-sm-offset-2 col-sm-2">
      <ul class="sortable02">
        {foreach name=ca_cate02 from=$opt_ca_cate02 key=num item=item}
          <li id="{$num}">{$item}</li>
        {/foreach}
      </ul>
      <input type="hidden" id="result02" name="result02" />
      {*<button id="sort">並び替え決定</button>*}
    </div>
    <div class="col-sm-offset-2 col-sm-2">
      <ul class="sortable03">
        {foreach name=ca_cate03 from=$opt_ca_cate03 key=num item=item}
          <li id="{$num}">{$item}</li>
        {/foreach}
      </ul>
      <input type="hidden" id="result03" name="result03" />
      {*<button id="sort">並び替え決定</button>*}
    </div>
  </div>





  <br><br><br>
  <div class="form-group">
    <label for="ca_name" class="col-sm-2 control-label">第一カテゴリ：追加</label>
    <div class="col-sm-4">
      {form_input('ca_name01' , set_value('ca_name01', '') , 'class="form-control" placeholder="追加する第一カテゴリを入力してください"')}
      {if $err_mess01 != NULL}<span class="label label-danger">Error : </span><label><font color=red>{$err_mess01}</font></label>{/if}
    </div>
    <div class="col-sm-6">
      <button type="submit" name="new" value="cate01">登録</button>
    </div>
  </div>
  <div class="form-group">
    <label for="ca_name" class="col-sm-2 control-label">第二カテゴリ：追加</label>
    <div class="col-sm-4">
      {form_input('ca_name02' , set_value('ca_name02', '') , 'class="form-control" placeholder="追加する第二カテゴリを入力してください"')}
      {if $err_mess02 != NULL}<span class="label label-danger">Error : </span><label><font color=red>{$err_mess02}</font></label>{/if}
    </div>
    <div class="col-sm-6">
      <button type="submit" name="new" value="cate02">登録</button>
      ※必ず第一カテゴリを選択してから「登録」ボタンを押してください。
    </div>
  </div>
  <div class="form-group">
    <label for="ca_name" class="col-sm-2 control-label">第三カテゴリ：追加</label>
    <div class="col-sm-4">
      {form_input('ca_name03' , set_value('ca_name03', '') , 'class="form-control" placeholder="追加する第三カテゴリを入力してください"')}
      {if $err_mess03 != NULL}<span class="label label-danger">Error : </span><label><font color=red>{$err_mess03}</font></label>{/if}
    </div>
    <div class="col-sm-6">
      <button type="submit" name="new" value="cate03">登録</button>
      ※必ず第一、第二カテゴリを選択してから「登録」ボタンを押してください。
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
