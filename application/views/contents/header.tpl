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
<link href="https://{$smarty.server.SERVER_NAME}/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://{$smarty.server.SERVER_NAME}/css/main.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="https://{$smarty.server.SERVER_NAME}/js/jquery-2.1.4.min.js"></script>
<script src="https://{$smarty.server.SERVER_NAME}/js/jquery-ui-3.0.2.custom.min.js"></script>
<script src="https://{$smarty.server.SERVER_NAME}/js/bootstrap.min.js"></script>

</head>


<small>グリッド&レスポンシブ対応</small>
<div>
  <section class="container">
  <!-- TwitterBootstrapのグリッドシステムclass="row"で開始 -->
  <div class="row">

    <div class="page-header">
      <ul class="list-inline text-right">
        <li><a href="/client/login/">Clientログイン</a></li>
        <li><a href="/admin/login/">ADMIINログイン</a></li>
      </ul>

      <nav class="navbar navbar-inverse">
      <div class="navbar-header">
          <a href="#" class="navbar-brand">FNOTE</a>
      </div>
      <div id="patern05" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="/">TOP</a></li>
          <li><a href="/genre/">ジャンル</a></li>
          <li><a href="/top/guide/">ご利用ガイド</a></li>
        </ul>
      </div>
      </nav>

      {*キーワード検索*}
      <form class="form-horizontal" name="searchForm" method="post" autocomplete="on" action="/searchlist/">

        <table class="table">
          <tbody>
            <tr>
              <td class="col-sm-1 text-right">KEYWORD</td>
              <td class="col-sm-4">
                <input type="text" class="form-control input-sm" id="keyword" name="keyword" value="{$serch_keyword|escape}" placeholder="キーワード指定。複数指定時はスペースで区切ってください。">
              </td>
              <td class="col-sm-1 text-right">× ACCESS</td>
              <td class="col-sm-4">
                <input type="text" class="form-control input-sm" id="access" name="access" value="{$serch_access|escape}" placeholder="場所(都道府県市区町村,駅名)。複数指定時はスペースで区切ってください。">
              </td>
              <td class="col-xs-1"><button type="submit" name="submit" value="_search" class="btn btn-primary btn-xs">検　　索</button></td>
          </tbody>
        </table>

      </form>
      <!-- </form> -->

    </div>
  </div>

