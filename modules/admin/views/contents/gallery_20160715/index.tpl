{* ヘッダー部分　START *}
    {include file="../header_gl.tpl" head_index="1"}

</head>

<body id="admin">
<div id="wrapper">
<h1>ギャラリー 管理画面</h1>
<h2>画像登録・編集フォーム</h2>

<form method="post" action="/admin/gallery/gd_new/" enctype="multipart/form-data" name="form">
{*form_open('/gallery/detail/' , 'name="galleryForm" class="form-horizontal"')*}

<p>日付：<input type="text" name="year" size="5" maxlength="4" value={$smarty.now|date_format:"%Y"} /> 年 <input type="text" name="month" size="2" maxlength="2" value={$smarty.now|date_format:"%m"} /> 月 <input type="text" name="day" size="2" maxlength="2" value={$smarty.now|date_format:"%d"} /> 日　※半角数字のみ</p>
<h3>写真タイトル、説明など（htmlタグ不可） </h3><p>※未入力も可　※画像拡大時、及びaltに反映されます。<br /><textarea name="title" cols="60" rows="3"></textarea>
</p>
<h3>画像アップロード（jpg、gif、pngのみ）</h3><p>
※事前に縮小の必要はありません。横写真または縦写真とも設定ファイル（config.php）で設定した幅、または高さに自動縮小されます。現在は<span style="color:red">{$imgWidthHeight}</span>px<br />※日本語ファイル名でも問題ありません。自動で半角英数字にリネームされます。アニメーションgifは不可<br />

<input type="file" name="upfile" size="50" /> （MAX 5MB）</p>
<p align="center"><input type="submit" class="submit_btn" name="submit" value="　新規登録　" onclick="return check()"/></p>

</form>


<div class="positionBase">
<h2>登録画像一覧　<?php if($mode == 'img_order') echo '【並び替えモード】';?></h2>
<div id="acrbtn">【取り扱い説明書】</div>
<div id="commentDescription" style="display:none">
<p>※デフォルトは登録順です。「並び替えモード」にて並び順の変更が可能です。ドラッグ＆ドロップし、「並び替えを反映する」ボタンを押して下さい。<br />
※画像の変更が反映されない場合はブラウザのキャッシュが原因です。→のボタンまたはF5キーで更新してください。
<button onclick="f5()">更新する</button>
<br />※アップ画像は幅、または高さが現在サムネイルのサイズとして設定されている<span class="col19"><?php echo $imgWidthHeightThumb;?>px</span>以上である必要があります。（設定ファイルで変更可）
</p>
</div>



{if $mode == "img_order"}
<div class="orderButton"><a href="?">通常モードへ</a></div>
{else}
<div class="orderButton"><a href="?mode=img_order">並び替えモードへ</a></div>
{/if}
</div><!-- /positionBase -->
<p class="taR pr10 pt10">[ 登録数：{$max_i}]</p>

<div id="gallery_wrap">
{if $mode != "img_order"}
<div class="pager_link">{$pager['pager_res']}</div>{*//ページャー表示*}
{/if}


{if $mode == "img_order"}{*//並び替えモード時*}
  <form method="post" action="admin.php?mode=img_order" enctype="multipart/form-data">
  <ul id="gallery_list" class="clearfix gallery_list_order">
{else}
 <ul id="gallery_list" class="clearfix">
{/if}


{*リスト表示処理 (START)*}

{section name=i loop=$html_char}
  <li>{$html_char[i]}</li>
{/section}








</ul>
{if $mode == "img_order"}{*並び替えモード時*}
  <div class="taC mt10">
  <input type="submit" class="submit_btn" name="order_submit" value="　並び替え反映　" /></div>
  </form>
{else}
  <div class="taC mt10"><input type="button" disabled="disabled"  value="並び替えは「並び替えモード」に切り替えて下さい" /></div>
{/if}
{if ($mode != 'img_order')}
  <div class="pager_link">{$pager['pager_res']}</div>{*ページャー表示*}
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
