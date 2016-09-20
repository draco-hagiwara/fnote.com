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
<script type="text/javascript" src="https://{$smarty.server.SERVER_NAME}/js/jQuery.jPrintArea.js"></script>{* 印刷プレビュー表示 *}

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDrmCOpsdAhrxRTHwHz9dnGGR-Ug73SzrA"></script>
{*<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>*}


{* 印刷プレビュー表示 *}
<script type="text/javascript">
$(function(){
  $('#btn_print1').click(function(){
    $.jPrintArea(".print-area");
  });

  $('#btn_print2').click(function(){
    $.jPrintArea(".print-area");
  });
});
</script>


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


<H3><p class="bg-info">事業者プラットフォーム　：　クーポン ＆ 地図</p></H3>


<p class="text-right">
  <input type="button" id="btn_print1" value="クーポン・地図を印刷">
</p>

{* 印刷範囲を設定 start *}
<div class="print-area">

<H2>{$tenpo.tp_shopname}　（{$tenpo.tp_shopname_sub}）</H2>

{* クーポン表示 *}
<div class="form-horizontal col-sm-10 col-sm-offset-2">
  <table class="table"  border="1">
  {foreach from=$coupon item=tnp}
    <tr>
      <td bgcolor="#ffffff">
        <img src="../../../images/coupon_tpl/{$tnp.tpl_img}" width=180 height=80 align="left">
        　{$tnp.cp_content}<br>
        　提示条件：　{$tnp.cp_presen}<br>
        　利用条件：　{$tnp.cp_use}<br>
        　使用期限：　{if $tnp.cp_start_date!="0000-00-00"}{$tnp.cp_start_date}　～　{/if}{$tnp.cp_end_date}　まで
      </td>
    </tr>
  {foreachelse}
    クーポンはありませんでした。
  {/foreach}
  </table>
</div>


{* google maps表示 *}
{if $tenpo.tp_google_map!=""}
<hr>
<div class="row col-sm-10 col-sm-offset-2">
<div id="gmap" style="width : 700px; height : 450px;"></div>{* サイズを大きくしすぎると印刷で表示されない？ *}
<script type="text/javascript">
google.maps.event.addDomListener(window, 'load', function() {
  var latlng = new google.maps.LatLng({$tenpo.tp_google_map});
  var opts = {
    zoom: 18,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  };
  var map = new google.maps.Map(document.getElementById("gmap"), opts);

  var m_latlng1 = new google.maps.LatLng({$tenpo.tp_google_map});
  var marker1 = new google.maps.Marker({
    position: m_latlng1,
    map: map
  });
});
</script>

</div>

<p class="text-right">
  <input type="button" id="btn_print2" value="クーポン・地図を印刷">
</p>

{/if}


<div class="row col-sm-10 col-sm-offset-2">
  <hr>
  <p><b>【　店　舗　情　報　】</b></p>
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td>{$tenpo.tp_shopname}　（{$tenpo.tp_shopname_sub}）</td>
      </tr>
      <tr>
        <td>〒{$tenpo.tp_zip01}-{$tenpo.tp_zip02}　{$tenpo.tp_prefname} {$tenpo.tp_addr01} {$tenpo.tp_addr02} {$tenpo.tp_buil}
        </td>
      </tr>
      <tr>
        <td>{$tenpo.tp_access}</td>
      </tr>
    </tbody>
  </table>
</div>

</div>
{* 印刷範囲を設定 end *}


<div class="row col-sm-10 col-sm-offset-2">
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td>ホームページ</td>
        <td>{$tenpo.tp_url}</td>
      </tr>
      <tr>
        <td>電話番号</td>
        <td>{$tenpo.tp_tel}</td>
      </tr>
      <tr>
        <td>営業時間</td>
        <td>{$tenpo.tp_opentime}</td>
      </tr>
      <tr>
        <td>定休日</td>
        <td>{$tenpo.tp_holiday}</td>
      </tr>
      <tr>
        <td>
          その他
        </td>
        <td>
          {if $tenpo.tp_free01}{$tenpo.tp_free01}<br><br>{/if}
        </td>
      </tr>
    </tbody>
  </table>

</div>


</section>


<section class="container">

  <br><br>
  <div>
    <ul class="list-inline text-center">
        <li id="qa"><a href="../../site/inquiry_edit/{$tenpo.tp_cl_siteid}">問合せ</a></li>
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
