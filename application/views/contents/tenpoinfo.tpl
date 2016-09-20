  <p><b>【　店　舗　情　報　】</b></p>
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td>名　　称</td>
        <td>{$tenpo.tp_shopname}　（{$tenpo.tp_shopname_sub}）</td>
      </tr>
      <tr>
        <td>ジャンル</td>
        <td>{$tenpo.tp_genre}</td>
      </tr>
      <tr>
        <td>公式サイト</td>
        <td>{$tenpo.tp_url}</td>
      </tr>
      <tr>
        <td>電話番号</td>
        <td>{$tenpo.tp_tel}</td>
      </tr>
      <tr>
        <td>住　　所</td>
        <td>
          〒{$tenpo.tp_zip01}-{$tenpo.tp_zip02}<br>
          {$tenpo.tp_prefname} {$tenpo.tp_addr01} {$tenpo.tp_addr02} {$tenpo.tp_buil}<br><br>
          {if $tenpo.tp_google_map!=""}<div id="gmap" style="width : 500px; height : 250px;"></div>
<script type="text/javascript">
google.maps.event.addDomListener(window, 'load', function() {
  var latlng = new google.maps.LatLng({$tenpo.tp_google_map});
  var opts = {
    zoom: 17,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    scrollwheel: false,
    //zoomControl: false,
    //navigationControl: false,
    //mapTypeControl: false,
    disableDefaultUI: true,
  };
  var map = new google.maps.Map(document.getElementById("gmap"), opts);

  var m_latlng1 = new google.maps.LatLng({$tenpo.tp_google_map});
  var marker1 = new google.maps.Marker({
    position: m_latlng1,
    map: map
  });
});
</script>
          <br>
          <p><a href="../../site/mp/{$tenpo.tp_cl_siteid}">詳しい地図はこちら</a></p>
          {/if}
        </td>
      </tr>
      <tr>
        <td>最寄り</td>
        <td>{$tenpo.tp_accessinfo}</td>
      </tr>
      <tr>
        <td>アクセス</td>
        <td>{$tenpo.tp_access}</td>
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
        <td>予算</td>
        <td>{$tenpo.tp_contents01}</td>
      </tr>
      <tr>
        <td>座席数</td>
        <td>{$tenpo.tp_seat}</td>
      </tr>
      <tr>
        <td>駐車場</td>
        <td>{$tenpo.tp_parking}</td>
      </tr>
      <tr>
        <td>カード情報</td>
        <td>{$tenpo.tp_card}</td>
      </tr>
      <tr>
        <td>喫煙</td>
        <td>{$tenpo.tp_smoking}</td>
      </tr>
      {if $tenpo.tp_free01}<tr>
        <td>その他</td>
        <td>
          {$tenpo.tp_free01}<br><br>
        </td>
      </tr>{/if}
    </tbody>
  </table>

  <hr>

  <div class="form-group">
    {$tenpo.tp_sns01}
  </div>
  <div class="form-group">
    {$tenpo.tp_sns02}
  </div>
  <div class="form-group">
    {$tenpo.tp_sns03}
  </div>
  <div class="form-group">
    {$tenpo.tp_sns04}
  </div>
  <div class="form-group">
    {$tenpo.tp_sns05}
  </div>

  {if $tenpo.tp_qrcode_site}サイトQRコード：<img src='/qr/qr_site/{$tenpo.tp_seq}' />{/if}
  {if $tenpo.tp_qrcode_google}googleQRコード：<img src='/qr/qr_gol/{$tenpo.tp_seq}' />{/if}
