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
    <ul class="list-inline text-right"></ul>
    <nav class="navbar navbar-inverse">
    <div class="navbar-header">
      <a href="/" class="navbar-brand">FNOTE</a>
    </div>
    <div id="patern05" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/site/pf/{$tenpo.tp_cl_siteid}"><i class="glyphicon glyphicon-home"></i> TOP</a></li>
        <li class="active"><a href="/site/mn/{$tenpo.tp_cl_siteid}"><i class="glyphicon glyphicon-menu-hamburger"></i> メニュー</a></li>
        {*<li class="active"><a href="/site/rv/{$tenpo.tp_cl_siteid}"><i class="glyphicon glyphicon-bullhorn"></i> 口コミ</a></li>*}
        <li class="active"><a href="/site/gd/{$tenpo.tp_cl_siteid}"><i class="glyphicon glyphicon-eye-open"></i> こだわり</a></li>
        <li class="active"><a href="/site/iv/{$tenpo.tp_cl_siteid}"><i class="glyphicon glyphicon-facetime-video"></i> インタビュー</a></li>
        <li class="active"><a href="/site/gl/{$tenpo.tp_cl_siteid}"><i class="glyphicon glyphicon-picture"></i> ギャラリー</a></li>
        <li class="active"><a href="/site/tc/{$tenpo.tp_cl_siteid}"><i class="glyphicon glyphicon-barcode"></i> チケット</a></li>
        <li class="active"><a href="/site/mp/{$tenpo.tp_cl_siteid}"><i class="glyphicon glyphicon-road"></i> クーポン・地図</a></li>
      </ul>
    </div>
    </nav>
  </div>

<body>

<H2>{$tenpo.tp_shopname}　（{$tenpo.tp_shopname_sub}）</H2>

<p class="bg-info">事業者プラットフォーム　：　ギャラリー</p>

<form class="form-horizontal" name="detailForm" method="post" action="/site/gl/">

  {foreach from=$gallery item=gls}
  <div class="row">
    {foreach from=$gls key=num item=gl}

    <div class="col-xs-6 col-md-2">
      <a href="#" class="thumbnail">
        <img src="/images/{$gl.gl_cl_siteid}/b/t_{$gl.gl_filename}" alt="{$gl.gl_title}">
      </a>
    </div>

    {/foreach}
  </div>
  {foreachelse}
    画像はありません。
  {/foreach}

</form>


<br><br>
<HR>
{* 店舗情報の読み込み *}{include file="../tenpoinfo.tpl"}
<HR>


</section>


<section class="container">

  <br><br>
  <div class="panel-body">
    <ul class="list-inline text-center">
        <li><a href="../../site/inquiry_edit/{$tenpo.tp_cl_siteid}">問合せ</a></li>
    </ul>
  </div>

</section>


<div class="panel panel-default">
  <div class="panel-footer text-center">
    Copyright(C) 2016 - {{$smarty.now|date_format:"%Y"}} Themis Inc. All Rights Reserved.
  </div>
</div>

</body>
</html>
