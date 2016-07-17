{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}
    {*include file="../header_gl.tpl" head_index="1"*}

</head>

<body id="admin">
<div id="wrapper">
<h2>画像登録・編集フォーム</h2>

<br><br>
{*<form method="post" action="/admin/gallery/gd_new/" enctype="multipart/form-data" name="form">*}
{form_open('/gallery/gd_new/' , 'name="galleryForm" enctype="multipart/form-data" class="form-horizontal"')}


<br><br>
<h2>画像アップロード（jpg、gif、pngのみ）</h2><p>
※事前に縮小の必要はありません。横写真または縦写真とも設定ファイル（config.php）で設定した幅、または高さに自動縮小されます。現在は<span style="color:red">600</span>px<br />※日本語ファイル名でも問題ありません。自動で半角英数字にリネームされます。アニメーションgifは不可<br />
<br><br>
<input type="file" name="upfile" size="50" /> （MAX 2MB）</p>

  <br><br>
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
      横px{form_input('im_width' , set_value('im_width', '600') , 'class="form-control" placeholder="px(4)"')}
    </div>
    <div class="col-sm-1">
      縦px{form_input('im_height' , set_value('im_height', '600') , 'class="form-control" placeholder="px(4)"')}
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


<br><br>
{form_hidden('cl_seq', $cl_seq)}
<p align="center"><input type="submit" class="submit_btn" name="submit" value="　新規登録　" onclick="return check()"/></p>


</form>


{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
