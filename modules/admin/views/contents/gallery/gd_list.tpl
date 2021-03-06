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

<script type="text/javascript">
function open_preview() {
    window.open("about:blank","preview","width=1170,height=650,scrollbars=yes");
    var form = document.imagesForm;
    form.target = "preview";
    form.method = "post";
    form.action = "/admin/gallery/images_list/";
    form.submit();
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
// -->
</script>


<body id="admin">
<div id="wrapper">

<form method="post" action="/admin/gallery/images_list/" enctype="multipart/form-data" name="imagesForm">
    <div class="row">
    <div class="col-sm-2">
      <button type='submit' name='_submit' value='gdlist' class="btn btn-sm btn-primary" onclick="open_preview();">画像リスト表示</button>
    </div>
    </div>
</form>

<H3><p class="bg-info">画像登録・編集フォーム</p></H3>

<br>
{if $gd_mode=='chg'}{* 編集or削除モード *}

  <form method="post" action="/admin/gallery/gd_list/" enctype="multipart/form-data" name="form">

  <p class="text-right">
    <button type='submit' name='_submit' value='_sort'>新規登録モードへ</button>
    <input type="hidden" name="chg_uniq" value={$list_image.im_cl_seq} />
  </p>

  </form>

  {form_open('/gallery/gd_edit/' , 'name="galleryForm" enctype="multipart/form-data" class="form-horizontal"')}

  <div class="form-group">
    <label for="size" class="col-sm-2 control-label">画像</label>
    <div class="col-sm-10">
      <img border="1" src="/images/{$list_image.im_cl_siteid}/s/{$list_image.im_filename}">
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
    <label for="im_tag" class="col-sm-2 control-label">タグ</label>
    <div class="col-sm-8">
      {form_input('im_tag' , set_value('im_tag', $list_image.im_tag) , 'class="form-control" placeholder="複数入力する場合は「,(半角カンマ)」で区切ってください。。max.20文字"')}
      {if form_error('im_tag')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('im_tag')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="im_header" class="col-sm-2 control-label">TOP画像</label>
    <div class="col-sm-8">
      {if $list_image.im_header==0}{form_checkbox('im_header', '1', FALSE)} TOP画像へ使用する
      {else}{form_checkbox('im_header', '1', TRUE)} TOP画像へ使用する
      {/if}
    </div>
  </div>
  <div class="form-group">
    <label for="im_status" class="col-sm-2 control-label">更新 o r削除</label>
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
  <p align="center"><button type='submit' name='_submit' value='_chgordel' class="btn btn-sm btn-primary">更新 または 削除</button></p>

  </form>

{else}{* 新規登録モード *}

  {form_open('/gallery/gd_new/' , 'name="galleryForm" enctype="multipart/form-data" class="form-horizontal"')}

  <p>画像アップロード（jpg、gif、pngのみ）</p>
  <p><input type="file" name="upfile[]" multiple="multiple" /> （MAX 2MB）</p>
  {*<p><input type="file" name="upfile" size="50" /> （MAX 2MB）</p>*}

  <br>
  <div class="form-group">
    <label for="im_title" class="col-sm-2 control-label">タイトル（alt）</label>
    <div class="col-sm-8">
      {form_input('im_title' , set_value('im_title', '') , 'class="form-control" placeholder="タイトル（alt）を入力してください。max.50文字"')}
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
  <div class="form-group">
    <label for="im_tag" class="col-sm-2 control-label">タグ</label>
    <div class="col-sm-8">
      {form_input('im_tag' , set_value('im_tag', '') , 'class="form-control" placeholder="複数入力する場合は「,(半角カンマ)」で区切ってください。。max.20文字"')}
      {if form_error('im_tag')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('im_tag')}</font></label>{/if}
    </div>
  </div>

  <br>
    <div class="row">
    <div class="col-sm-4 col-sm-offset-2">
      <button type='submit' name='_submit' value='_new' class="btn btn-sm btn-primary">　新規登録　</button>
    </div>
    <div class="col-sm-2 col-sm-offset-4">
      <button type="button" class="btn btn-primary btn-sm" onclick="fmSubmit('galleryForm', '/admin/tenpo_site/tenpo_edit/', 'POST', '{$smarty.session.a_img_clseq}', 'chg_uniq');">店舗情報</button>
      <button type="button" class="btn btn-primary btn-sm" onclick="fmSubmit('galleryForm', '/admin/tenpo_interview/report_edit/', 'POST', '{$smarty.session.a_img_clseq}', 'chg_uniq');">記事本文</button>
    </div>
  </div>

  </form>

{/if}

<br>
<H3><p class="bg-info">登録画像一覧</p></H3>

<form method="post" action="/admin/gallery/gd_list/" enctype="multipart/form-data" name="form">

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
