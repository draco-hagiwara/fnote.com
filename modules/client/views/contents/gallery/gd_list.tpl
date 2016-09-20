{* ヘッダー部分　START *}
    {include file="../header.tpl"}


<script>
<!--
$(function(){
  /*================================================
    ファイルをドロップした時の処理
  =================================================*/
  $('#drag-area').bind('drop', function(e){
    // デフォルトの挙動を停止
    e.preventDefault();

    // ファイル情報を取得
    var files = e.originalEvent.dataTransfer.files;

    uploadFiles(files);

  }).bind('dragenter', function(){
    // デフォルトの挙動を停止
    return false;
  }).bind('dragover', function(){
    // デフォルトの挙動を停止
    return false;
  });

  /*================================================
    ダミーボタンを押した時の処理
  =================================================*/
  $('#btn').click(function() {
    // ダミーボタンとinput[type="file"]を連動
    $('input[type="file"]').click();
  });

  $('input[type="file"]').change(function(){
    // ファイル情報を取得
    var files = this.files;

    uploadFiles(files);
  });

});

/*================================================
  アップロード処理
=================================================*/
function uploadFiles(files) {
  // FormDataオブジェクトを用意
  var fd = new FormData();

  // ファイルの個数を取得
  var filesLength = files.length;

  // ファイル情報を追加
  for (var i = 0; i < filesLength; i++) {
    //alert(files[i]["name"]);
    fd.append("files[]", files[i]);
  }

  // Ajaxでアップロード処理をするファイルへ内容渡す
  $.ajax({
    url: '/client/gallery/gd_new_dd/',
    type: 'POST',
    data: fd,
    processData: false,
    contentType: false,
    success: function(data) {
      //alert(data);
      location.reload();
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.log(XMLHttpRequest.responseText);
    }
  });
  //サブミット後、ページをリロードしないようにする
  //return false;
}
//-->
</script>


</head>

<link rel="stylesheet" href="{base_url()}../../gallery/style.css">

<script type="text/javascript">
//<!--
//function fmSubmit(formName, url, method, num) {
//  var f1 = document.forms['galleryForm'];
//
//  console.log(num);
//
//  /* エレメント作成&データ設定&要素追加 */
//  var e1 = document.createElement('input');
//  e1.setAttribute('type', 'hidden');
//  e1.setAttribute('name', 'chg_uniq');
//  e1.setAttribute('value', num);
//  f1.appendChild(e1);
//
//  /* サブミットするフォームを取得 */
//  f1.method = method;                                   // method(GET or POST)を設定する
//  f1.action = url;                                      // action(遷移先URL)を設定する
//  f1.submit();                                          // submit する
//  return true;
//}
// -->
</script>


<body id="client">
<div id="wrapper">

<p class="bg-info">画像登録・編集フォーム</p>

<br>
{if $gd_mode=='chg'}{* 編集or削除モード *}

  <form method="post" action="/client/gallery/gd_list/" enctype="multipart/form-data" name="form">

  <p class="text-right">
    <button type='submit' name='_submit' value='_sort'>新規登録モードへ</button>
    <input type="hidden" name="chg_uniq" value={$list_image.gl_cl_seq} />
  </p>

  </form>

  {form_open('/gallery/gd_edit/' , 'name="galleryForm" enctype="multipart/form-data" class="form-horizontal"')}

  <div class="form-group">
    <label for="size" class="col-sm-2 control-label">画像</label>
    <div class="col-sm-10">
      <img border="1" src="/images/{$list_image.gl_cl_siteid}/b/{$list_image.gl_filename}">
    </div>
  </div>
  <div class="form-group">
    <label for="size" class="col-sm-2 control-label">IMGタグ</label>
    <div class="col-sm-1">
      <p>標準画像</p>
    </div>
    <div class="col-sm-9">
      <p>img src="/images/{$list_image.gl_cl_siteid}/b/{$list_image.gl_filename}" width={$list_image.gl_width} height={$list_image.gl_height} alt=""</p>
    </div><br>
    <div class="col-sm-1 col-sm-offset-2">
      <p>スマホ画像</p>
    </div>
    <div class="col-sm-9">
      <p>img src="/images/{$list_image.gl_cl_siteid}/b/s_{$list_image.gl_filename}" alt=""</p>
    </div><br>
    <div class="col-sm-1 col-sm-offset-2">
      <p>サムネイル</p>
    </div>
    <div class="col-sm-9">
      <p>img src="/images/{$list_image.gl_cl_siteid}/b/t_{$list_image.gl_filename}" alt=""</p>
    </div>
  </div>
  <div class="form-group">
    <label for="size" class="col-sm-2 control-label">画像サイズ</label>
    <div class="col-sm-5">
      横：{$list_image.gl_width} px　,　縦：{$list_image.gl_height} px　,　容量：{$list_image.gl_size} Byte
    </div>
  </div>


    <div class="form-group">
    <label for="gl_title" class="col-sm-2 control-label">タイトル（alt）</label>
    <div class="col-sm-8">
      {form_input('gl_title' , set_value('gl_title', $list_image.gl_title) , 'class="form-control" placeholder="タイトル（alt）を入力してください。max.50文字"')}
      {if form_error('gl_title')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gl_title')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="gl_description" class="col-sm-2 control-label">画像説明</label>
    <div class="col-sm-8">
      <textarea class="form-control input-sm" id="gl_description" name="gl_description" placeholder="画像説明を入力してください。max.255文字">{$list_image.gl_description}</textarea>
      {if form_error('gl_description')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gl_description')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="gl_tag" class="col-sm-2 control-label">タグ</label>
    <div class="col-sm-8">
      {form_input('gl_tag' , set_value('gl_tag', $list_image.gl_tag) , 'class="form-control" placeholder="複数入力する場合は「,(半角カンマ)」で区切ってください。。max.20文字"')}
      {if form_error('gl_tag')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gl_tag')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="gl_cate" class="col-sm-2 control-label">カテゴリ分類</label>
    <div class="col-sm-3 btn-lg">
      {form_dropdown('gl_cate', $opt_imgcate, set_value('gl_cate', $list_image.gl_cate))}
      {if form_error('gl_cate')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gl_cate')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="gl_disp_no" class="col-sm-2 control-label">表示順序指定</label>
    <div class="col-sm-1">
      {form_input('gl_disp_no' , set_value('gl_disp_no', $list_image.gl_disp_no) , 'class="form-control" placeholder="数字"')}
      {if form_error('gl_disp_no')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('gl_disp_no')}</font></label>{/if}
    </div>
  </div>


  <div class="form-group">
    <label for="gl_status" class="col-sm-2 control-label">更新 o r削除</label>
    <div class="col-sm-8">
      <label class="radio-inline">
        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="0" checked> 内容の更新
      </label>
      <label class="radio-inline">
        <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="1"> 画像の削除
      </label>
    </div>
  </div>

  <input type="hidden" name="gl_filename" value={$list_image.gl_filename} />
  <input type="hidden" name="gl_cl_siteid" value={$list_image.gl_cl_siteid} />

  <br>
  <p align="center"><button type='submit' name='_submit' value='_chgordel' class="btn btn-sm btn-primary">更新 または 削除</button></p>

  {form_close()}

{else}{* 新規登録モード *}

  {if $ie_ver == FALSE}{* IEのバージョン 1～9 *}
    {form_open('/gallery/gd_new/' , 'name="galleryForm" enctype="multipart/form-data" class="form-horizontal"')}

    <div class="row">
      <label for="gl_description" class="col-sm-2 control-label">画像アップロード<br>（jpg、gif、pngのみ）</label>
      <div class="col-sm-10">
        <input type="file" name="files[]" multiple="multiple" /> （MAX 2MB）
      </div>
    </div>

    <div class="row">
      <div class="col-sm-4 col-sm-offset-2">
        <button type='submit' name='_submit' value='_new' class="btn btn-sm btn-primary">　新規登録　</button>
      </div>
    </div>

  {form_close()}

  {else}

    <div class="row">
      <label for="gl_description" class="col-sm-2 control-label">画像アップロード<br>（jpg、gif、pngのみ）</label>
      <div class="col-sm-9" id="drag-area" style="border-style: dotted;background-color: #fff8dc;">
        <p>アップロードするファイルをドロップ</p>
        <p>または</p>
        <div class="btn-group">
        <input type="file" multiple="multiple" style="display:none;" name="files"/>
        <button id="btn">ファイルを選択</button>
        </div>
      </div>
    </div>

  {/if}

{/if}

<br><br>
<p class="bg-info">登録画像一覧</p>

<form method="post" action="/client/gallery/gd_list/" enctype="multipart/form-data" name="form">

  <p class="text-right">
  {if $list_mode=='edit'}
    <button type='submit' name='_submit' value='_sort'>並び替えモードへ</button>
    <input type="hidden" name="list_mode" value='sort' />
  {else}
    <button type='submit' name='_submit' value='_edit'>編集モードへ</button>
    <input type="hidden" name="list_mode" value='edit' />
  {/if}
  </p>

</form>

{if $list_mode=='edit'}
  <p>編集モード :: {$countall} 枚</p>

  <form method="post" action="/client/gallery/gd_list/" enctype="multipart/form-data" name="form">

  <div id="gallery_wrap">
    <ul id="gallery_list" class="clearfix">
        {foreach from=$str_html item=list}
                    {$list}
        {foreachelse}
          画像はありませんでした。
        {/foreach}
    </ul>
  </div>

  <input type="hidden" name="list_mode" value={$list_mode} />

  <ul class="pagination pagination-sm">
    {$set_pagination}
  </ul>

  </form>

{else}
  <p>並び替えモード :: {$img_cnt} 枚</p>

  {form_open('/gallery/gd_list/' , 'name="listForm" class="form-horizontal"')}

  {if $str_html|@count != 0}
  <input type="submit" id="submit" value="並び順を保存する" />
  {/if}

  <div id="gallery_wrap">
    <ul id="gallery_list" class="sortable">
        {foreach from=$str_html item=list}
          {$list}
        {foreachelse}
          画像はありませんでした。
        {/foreach}
    </ul>
  </div>

  <input type="hidden" id="result" name="result" />
  <input type="hidden" name="list_mode" value={$list_mode} />

  {form_close()}

<script>
$(function() {
    $(".sortable").sortable();
    $(".sortable").disableSelection();
    $("#submit").click(function() {
        var result = $(".sortable").sortable("toArray");
        $("#result").val(result);
        $("form").submit();
    });
});
</script>

{/if}


{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
