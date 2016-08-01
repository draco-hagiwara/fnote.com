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

</head>

<small>グリッド&レスポンシブ対応</small>
<div>
  <section class="container">
    <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
    <div class="row">

    {if $login_chk==TRUE}
      <ul class="list-inline text-right">
        {$mem_Name} 様
      </ul>
      <nav class="navbar navbar-inverse">
      <div class="navbar-header">
          <a href="#" class="navbar-brand">Fnote</a>
      </div>
      <div id="patern05" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="/client/top/">TOP</a></li>
          <li class="active"><a href="/client/newslist/">新着情報管理</a></li>
          <li class="active"><a href="/client/reply/">問合せ管理</a></li>
          <li class="active"><a href="/client/clientinfo/">会社情報</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="#" class="dropdown-toggle" data-toggle="dropdown">その他<b class="caret"></b></a>
            <ul class="dropdown-menu right">
              <li><a href="/client/mypage/contact/">サポート問合せ</a></li>
              <li><a href="/client/mypage/chgidpw/">パスワード変更</a></li>
            </ul>
          </li>
          <li class="active"><a href="/client/login/logout/">ログアウト</a></li>
        </ul>
      </div>
      </nav>
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
          <a href="/client/login/" class="navbar-brand">クライアント管理</a>
        </div>
      </nav>

      <ul class="list-inline text-right">
        <li><a href="/pf/client/login/">Clientログイン</a></li>
        <li><a href="/pf/admin/login/">ADMIINログイン</a></li>
      </ul>
    </div>
    {/if}

</div>
