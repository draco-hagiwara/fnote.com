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

    {if $login_chk==TRUE}
      {if $mem_type==2}{*管理者用メニュー*}
        <ul class="list-inline text-right"></ul>
        <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Fnote</a>
        </div>
        <div id="patern05" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/admin/top/"><i class="glyphicon glyphicon-cloud"></i>TOP</a></li>
            <li><a href="/admin/clientlist/"><i class="glyphicon glyphicon-list"></i>クライアント一覧</a></li>
            <li><a href="/admin/entryclient/"><i class="glyphicon glyphicon-facetime-video"></i>クライアント登録</a></li>
            <li><a href="/admin/accountlist/"><i class="glyphicon glyphicon-list"></i>アカウント一覧</a></li>
            <li><a href="/admin/Entryadmin/"><i class="glyphicon glyphicon-user"></i>アカウント登録</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-wrench"></i>システム設定<b class="caret"></b></a>
              <ul class="dropdown-menu right">
                <li><a href="/admin/system/mailtpl/"><i class="glyphicon glyphicon-envelope"></i>メールテンプレ管理</a></li>
                {if $smarty.session.a_memSeq==1}<li><a href="/admin/system/backup/"><i class="glyphicon glyphicon-chevron-right"></i>手動バックアップ</a></li>{/if}
              </ul>
            </li>
            <li><a href="/admin/login/logout/"><i class="glyphicon glyphicon-log-out"></i>ログアウト</a></li>
          </ul>
        </div>
        </nav>
      {elseif $mem_type==1}{*営業用メニュー*}
        <ul class="list-inline text-right"></ul>
        <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Fnote</a>
        </div>
        <div id="patern05" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/admin/top/">TOP</a></li>
            <li><a href="/admin/clientlist/">クライアント一覧</a></li>
            <li><a href="/admin/accountlist/detail/">アカウント編集</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/admin/login/logout/">ログアウト</a></li>
          </ul>
        </div>
        </nav>
      {elseif $mem_type==0}{*編集者用メニュー*}
        <ul class="list-inline text-right"></ul>
        <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Fnote</a>
        </div>
        <div id="patern05" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/admin/clientlist/">クライアント一覧</a></li>
            <li><a href="/admin/accountlist/detail">アカウント編集</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/admin/login/logout/">ログアウト</a></li>
          </ul>
        </div>
        </nav>
      {/if}
    {else}
    <div class="page-header">
      <ul class="list-inline text-right">
        <li><a href="/entrywriter/">新規会員登録</a></li>
        <li><a href="/writer/login/">ログイン</a></li>
      </ul>

      <nav class="navbar navbar-inverse">
        <div class="navbar-header">toggle="collapse" data-target="#patern05">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <a href="/admin/login/" class="navbar-brand">アドミン管理</a>
        </div>
      </nav>

      <ul class="list-inline text-right">
        <li><a href="/pf/client/login/">Clientログイン</a></li>
        <li><a href="/pf/admin/login/">ADMIINログイン</a></li>
      </ul>

    </div>
    {/if}

</div>
