<!DOCTYPE html>
<html class="no-js" lang="jp">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>プラットフォーム &#xB7; FNOTE</title>

{* Versionと並び順に注意 *}
<link href="{base_url()}../../css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{base_url()}../../js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDrmCOpsdAhrxRTHwHz9dnGGR-Ug73SzrA"></script>
{*<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>*}

</head>

<div>
  <section class="container">
  <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
  <div class="row">

  </div>

<body>

<H3><p class="bg-info">登録画像　リスト</p></H3>

<br>

  <div class="form-horizontal col-sm-12">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>画像</th>
          <th>IMG タグ （本文に貼り付ける際には、「< >」で括ってください。）</th>
        </tr>
      </thead>

{foreach from=$list_image item=img  name="seq"}

        <tbody>
          <tr>
            <td>
              {$smarty.foreach.seq.iteration}
            </td>
            <td>
              <img border="1" src="/images/{$img.im_cl_siteid}/s/t_{$img.im_filename}" width="100">
            </td>
            <td>
              <div class="col-sm-2">
                <small>標準画像</small>
              </div>
              <div class="col-sm-9">
                <small>img src="/images/{$img.im_cl_siteid}/s/{$img.im_filename}" width={$img.im_width} height={$img.im_height} alt=""</small>
              </div><br>
              <div class="col-sm-2">
                <small>スマホ画像</small>
              </div>
              <div class="col-sm-9">
                <small>img src="/images/{$img.im_cl_siteid}/s/s_{$img.im_filename}" alt=""</small>
              </div><br>
              <div class="col-sm-2">
                <small>サムネイル</small>
              </div>
              <div class="col-sm-9">
                <small>img src="/images/{$img.im_cl_siteid}/s/t_{$img.im_filename}" alt=""</small>
              </div><br>
              <div class="col-sm-2">
                <small>画像サイズ</small>
              </div>
              <div class="col-sm-9">
                <small>横：{$img.im_width} px　,　縦：{$img.im_height} px　,　容量：{$img.im_size} Byte</small>
              </div><br>
              {if $img.im_title}<div class="col-sm-2">
                <small>タイトル</small>
              </div>
              <div class="col-sm-9">
                <small>{$img.im_title}</small>
              </div><br>{/if}
              {if $img.im_description}<div class="col-sm-2">
                <small>説明</small>
              </div>
              <div class="col-sm-9">
                <small>{$img.im_description}</small>
              </div>{/if}
            </td>
          </tr>
        </tbody>
{foreachelse}
  画像リストはありません。
{/foreach}

  </table>
</div>







{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
