{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}
    {*include file="../header_gl.tpl" head_index="1"*}



<style type="text/css">
<!--
/*---------------------------------
	 ▼Gallery.php style▼
---------------------------------*/
body#admin #gallery_wrap {
	width:992px;
}
body#admin #gallery_list li{
	width:112px;
	height:152px;
	border:1px solid #ccc;
	float:left;
	margin:0 5px 5px 0;
	overflow:hidden;
	padding:5px;
	text-align:center;
	font-size:12px;
	position:relative;

}
body#admin ul.gallery_list_order li{
	cursor:move;
	padding-top:25px!important;
	height:92px!important;
}
.gallery_list_order li a.button{
	 display:none!important;
}
.hidden_text{
	position:absolute;
	top:50px;
	left:27px;
	color:#F00;
	font-weight:bold;
	font-size:14px;
}
body#admin #gallery_list a{
	display:block;
}
body#admin #gallery_list a.photo{
	width:100px;
	margin:0 auto;
	height:80px;
	overflow:hidden;
}

body#admin #gallery_list a.button{
	padding:3px 5px;
	text-decoration:none;
	color:#fff;
	margin:2px auto;
	background:#555;
	height:20px;
	width:100px;
}
body#admin #gallery_list a.button:hover{
	background:#000;
}
body#admin .submit_btn {
	width:240px;
	height:30px;
	cursor:pointer;
}
-->
</style>

</head>

<body id="admin">
<div id="wrapper">

<H3><p class="bg-info">画像登録・編集フォーム</p></H3>

<br>
{if $gd_mode=='chg'}

  <form method="post" action="/admin/gallery/gd_list/" enctype="multipart/form-data" name="form">

  <p class="text-right">
    <button type='submit' name='submit' value='_sort'>新規登録モードへ</button>
    <input type="hidden" name="chg_uniq" value={$list_image.im_cl_seq} />
  </p>

  </form>

  {form_open('/gallery/gd_edit/' , 'name="galleryForm" enctype="multipart/form-data" class="form-horizontal"')}

  <div class="form-group">
    <label for="size" class="col-sm-2 control-label">画像</label>
    <div class="col-sm-10">
      <img border="1" src="/images/{$list_image.im_cl_siteid}/s/{$list_image.im_filename}" height="250">
    </div>
  </div>
  <div class="form-group">
    <label for="size" class="col-sm-2 control-label">IMGタグ</label>
    <div class="col-sm-1">
      <p>標準画像</p>
    </div>
    <div class="col-sm-9">
      <p>img src="/images/{$list_image.im_cl_siteid}/s/{$list_image.im_filename}" width={$list_image.im_width} height={$list_image.im_height} alt=""</p>
    </div><br>
    <div class="col-sm-1 col-sm-offset-2">
      <p>スマホ画像</p>
    </div>
    <div class="col-sm-9">
      <p>img src="/images/{$list_image.im_cl_siteid}/s/s_{$list_image.im_filename}" alt=""</p>
    </div><br>
    <div class="col-sm-1 col-sm-offset-2">
      <p>サムネイル</p>
    </div>
    <div class="col-sm-9">
      <p>img src="/images/{$list_image.im_cl_siteid}/s/t_{$list_image.im_filename}" alt=""</p>
    </div>
  </div>
  <div class="form-group">
    <label for="size" class="col-sm-2 control-label">画像サイズ</label>
    <div class="col-sm-5">
      横：{$list_image.im_width} px　,　縦：{$list_image.im_height} px　,　容量：{$list_image.im_size} Byte
    </div>
  </div>
  <div class="form-group">
    <label for="im_title" class="col-sm-2 control-label">タイトル（alt）</label>
    <div class="col-sm-8">
      {form_input('im_title' , set_value('im_title', $list_image.im_title) , 'class="form-control" placeholder="タイトル（alt）を入力してください"')}
      {if form_error('im_title')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('im_title')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="im_description" class="col-sm-2 control-label">画像説明</label>
    <div class="col-sm-8">
      <textarea class="form-control input-sm" id="im_description" name="im_description" placeholder="画像説明を入力してください。max.255文字">{$list_image.im_description}</textarea>
      {if form_error('im_description')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('im_description')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="im_status" class="col-sm-2 control-label">更新削除の選択</label>
    <div class="col-sm-8">
      <label class="radio-inline">
        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="0" checked> 内容の更新
      </label>
      <label class="radio-inline">
        <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="1"> 画像の削除
      </label>
    </div>
  </div>

  <input type="hidden" name="im_filename" value={$list_image.im_filename} />
  <input type="hidden" name="im_cl_siteid" value={$list_image.im_cl_siteid} />

  <br>
  <p align="center"><button type='submit' name='submit' value='_chgordel' class="btn btn-sm btn-primary">更新 または 削除</button></p>

  </form>

{else}

  {form_open('/gallery/gd_new/' , 'name="galleryForm" enctype="multipart/form-data" class="form-horizontal"')}

  <p>画像アップロード（jpg、gif、pngのみ）</p>
  <p><input type="file" name="upfile" size="50" /> （MAX 2MB）</p>

  <br>
  <div class="form-group">
    <label for="im_title" class="col-sm-2 control-label">タイトル（alt）</label>
    <div class="col-sm-8">
      {form_input('im_title' , set_value('im_title', '') , 'class="form-control" placeholder="タイトル（alt）を入力してください"')}
      {if form_error('im_title')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('im_title')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="size" class="col-sm-2 control-label">画像縮小サイズ<font color=red>【必須】</font></label>
    <div class="col-sm-1">
      縦px{form_input('im_height' , set_value('im_height', '600') , 'class="form-control" placeholder="px(4)"')}
    </div>
    <div class="col-sm-1">
      横px{form_input('im_width' , set_value('im_width', '600') , 'class="form-control" placeholder="px(4)"')}
    </div>
    <div class="col-sm-8">
      ※縦横比率を保持します。<br>
      ※画像が縦長の場合は縦サイズを、横長の場合は横サイズを基準としてリサイズします。
    </div>
    <div class="col-sm-4">
      {if form_error('im_width')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('im_width')}</font></label>{/if}
      <br>
      {if form_error('im_height')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('im_height')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="im_description" class="col-sm-2 control-label">画像説明</label>
    <div class="col-sm-8">
      <textarea class="form-control input-sm" id="im_description" name="im_description" placeholder="画像説明を入力してください。max.255文字"></textarea>
      {if form_error('im_description')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('im_description')}</font></label>{/if}
    </div>
  </div>

  <br>
  <p align="center"><button type='submit' name='submit' value='_new' class="btn btn-sm btn-primary">　新規登録　</button></p>

  </form>

{/if}

<br>
<H3><p class="bg-info">登録画像一覧</p></H3>

<form method="post" action="/admin/gallery/gd_list/" enctype="multipart/form-data" name="form">

  <p class="text-right">
  {if $list_mode=='edit'}
    <button type='submit' name='submit' value='_sort'>並び替えモードへ</button>
    <input type="hidden" name="list_mode" value='sort' />
  {else}
    <button type='submit' name='submit' value='_edit'>編集モードへ</button>
    <input type="hidden" name="list_mode" value='edit' />
  {/if}
  </p>

</form>

{if $list_mode=='edit'}
<p>編集モード :: {$img_cnt} 枚</p>
  <form method="post" action="/admin/gallery/gd_list/" enctype="multipart/form-data" name="form">

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

  </form>

{else}
<p>並び替えモード :: {$img_cnt} 枚</p>

  {*<form method="post" action="/admin/gallery/gd_new/" enctype="multipart/form-data" name="form">*}

  {form_open('/gallery/gd_list/' , 'name="listForm" class="form-horizontal"')}

  <input type="submit" id="submit" value="並び順を保存する" />

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
