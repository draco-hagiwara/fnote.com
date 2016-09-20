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
<link rel="stylesheet" type="text/css" href="{base_url()}../../js/gallery/lightbox/jquery.lightbox-0.5.css"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{base_url()}../../js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script type="text/javascript" src="{base_url()}../../js/gallery/common.js"></script>
<script type="text/javascript" src="{base_url()}../../js/gallery/lightbox/jquery.lightbox-0.5.min.js"></script>



</head>

<small>グリッド&レスポンシブ対応</small>
<div>
  <section class="container">
    <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
    <div class="row">

    {if $login_chk==TRUE AND !isset($smarty.session.c_adminSeq)}
      <ul class="list-inline text-right">
        {$mem_Name} 様
      </ul>
      <nav class="navbar navbar-inverse">
      <div class="navbar-header">
          <a href="#" class="navbar-brand">Fnote</a>
      </div>
      <div id="patern05" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="/client/top/"><i class="glyphicon glyphicon-home"></i> TOP</a></li>
          <li class="active"><a href="/client/newslist/"><i class="glyphicon glyphicon-list-alt"></i> 新着情報管理</a></li>
          <li class="active"><a href="/client/reply/"><i class="glyphicon glyphicon-envelope"></i> 問合せ管理</a></li>
          <li class="active"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-book"></i> ブログ管理<b class="caret"></b></a>
            <ul class="dropdown-menu right">
              <li><a href="/client/blog/"><i class="glyphicon glyphicon-pencil"></i> 投稿</a></li>
              <li><a href="/client/blog/comment/"><i class="glyphicon glyphicon-paperclip"></i> コメント管理</a></li>
            </ul>
          </li>
          <li class="active"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-phone"></i> サイト管理<b class="caret"></b></a>
            <ul class="dropdown-menu right">
              <li><a href="/client/tenpo_menu/"><i class="glyphicon glyphicon-menu-hamburger"></i> メニュー管理</a></li>
              <li><a href="/client/blog/comment/"><i class="glyphicon glyphicon-comment"></i> 口コミ管理</a></li>
              <li><a href="/client/tenpo_coupon/"><i class="glyphicon glyphicon-barcode"></i> クーポン管理</a></li>
              <li><a href="/client/gallery/gd_list/"><i class="glyphicon glyphicon-camera"></i> ギャラリー</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-alert"></i> その他<b class="caret"></b></a>
            <ul class="dropdown-menu right">
              <li><a href="/client/mypage/contact/"><i class="glyphicon glyphicon-earphone"></i> サポート 問合せ</a></li>
              <li><a href="/client/mypage/info/"><i class="glyphicon glyphicon-user"></i> 基本情報 設定</a></li>
              <li><a href="/client/clientinfo/"><i class="glyphicon glyphicon-globe"></i> 会社情報</a></li>
            </ul>
          </li>
          <li class="active"><a href="/client/login/logout/"><i class="glyphicon glyphicon-log-out"></i> ログアウト</a></li>
        </ul>
      </div>
      </nav>
    {elseif $login_chk==TRUE AND isset($smarty.session.c_adminSeq)}
      <ul class="list-inline text-right">
        {$mem_Name} 様（管理権限）
      </ul>
      <nav class="navbar navbar-inverse">
      <div class="navbar-header">
          <a href="#" class="navbar-brand">Fnote</a>
      </div>
      <div id="patern05" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="/client/top/"><i class="glyphicon glyphicon-home"></i> TOP</a></li>
          <li class="active"><a href="/client/tenpo_menu/"><i class="glyphicon glyphicon-menu-hamburger"></i> メニュー管理</a></li>
          <li><a href="#"><i class="glyphicon glyphicon-comment"></i> 口コミ管理</a></li>
          <li class="active"><a href="/client/tenpo_coupon/"><i class="glyphicon glyphicon-barcode"></i> クーポン管理</a></li>
          <li class="active"><a href="/client/gallery/gd_list/"><i class="glyphicon glyphicon-camera"></i> ギャラリー</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="/client/login/adminlogout/"><i class="glyphicon glyphicon-log-out"></i> ログアウト</a></li>
        </ul>
      </div>
      </nav>
    {else}
    <div class="page-header">
      <ul class="list-inline text-right">
        <li><a href="/">TOP</a></li>
        <li><a href="/admin/login/">ADMIINログイン</a></li>
      </ul>

      <nav class="navbar navbar-inverse">
        <div class="navbar-header">toggle="collapse" data-target="#patern05">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <a href="/client/login/" class="navbar-brand">事業者管理画面</a>
        </div>
      </nav>

    </div>
    {/if}

  </div>
