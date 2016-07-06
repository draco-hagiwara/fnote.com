<!DOCTYPE html>
<html class="no-js" lang="jp">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>CS &#xB7; Crowd Sourcing</title>

{* Versionと並び順に注意 *}
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>



</head>


<small>グリッド&レスポンシブ対応</small>
<div>
  <section class="container">
    <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
    <div class="row">

    {if $login_chk==TRUE}
      {if $mem_type==2}{*管理者用メニュー*}
      <div class="page-header">
        <ul class="list-inline text-right"></ul>
        <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Fnote</a>
        </div>
        <div id="patern05" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/admin/top/">TOP</a></li>
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">アカウント<b class="caret"></b></a>
              <ul class="dropdown-menu right">
                <li><a href="/admin/accountlist/">アカウント一覧</a></li>
                <li><a href="/admin/entryadmin/">アカウント追加</a></li>
              </ul>
            </li>
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">クライアント<b class="caret"></b></a>
              <ul class="dropdown-menu right">
                <li><a href="/admin/clientlist">クライアント一覧</a></li>
                <li><a href="/admin/entryclient">クライアント追加</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">システム設定<b class="caret"></b></a>
              <ul class="dropdown-menu right">
                <li><a href="/admin/backup/">手動バックアップ</a></li>
                <li><a href="/admin/mailtpl/">メールテンプレ管理</a></li>
              </ul>
            </li>
            <li><a href="/admin/login/logout/">ログアウト</a></li>
          </ul>
        </div>
        </nav>
      </div>
      {elseif $mem_type==1}{*営業用メニュー*}
      <div class="page-header">
        <ul class="list-inline text-right"></ul>
        <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Fnote</a>
        </div>
        <div id="patern05" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/admin/top/">TOP</a></li>
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">アカウント<b class="caret"></b></a>
              <ul class="dropdown-menu right">
                <li><a href="/admin/accountlist/">アカウント一覧</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/admin/login/logout/">ログアウト</a></li>
          </ul>
        </div>
        </nav>
      </div>
      {elseif $mem_type==0}{*編集者用メニュー*}
      <div class="page-header">
        <ul class="list-inline text-right"></ul>
        <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a href="#" class="navbar-brand">Fnote</a>
        </div>
        <div id="patern05" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">クライアント<b class="caret"></b></a>
              <ul class="dropdown-menu right">
                <li><a href="/admin/clientlist">クライアント一覧</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/admin/login/logout/">ログアウト</a></li>
          </ul>
        </div>
        </nav>
      </div>
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
        <li><a href="/client/login/">Clientログイン</a></li>
        <li><a href="/admin/login/">ADMIINログイン</a></li>
      </ul>

    </div>
    {/if}
