{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}


{*<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>*}


<script type="text/javascript">

//File APIに対応していない場合はエリアを隠す
if (!window.File) {
    document.getElementById('image_upload_section').style.display = "none";
}

// ブラウザ上でファイルを展開する挙動を抑止
function onDragOver(event) {
    event.preventDefault();
}

//Drop領域にドロップした際のファイルのプロパティ情報読み取り処理
function onDrop(event) {
  // （3）ブラウザ上でファイルを展開する挙動を抑止
  event.preventDefault();
  // （1）ドロップされたファイルのfilesプロパティを参照
  var files = event.dataTransfer.files;
  var disp = document.getElementById("disp");

  disp.innerHTML = "";
  for (var i = 0; i < files.length; i++) {
    var f = files[i];
    // （2）ファイル名とサイズを表示
    disp.innerHTML += "ファイル名 :" + f.name + "ファイルの型:" + f.type + "ファイルサイズ:" + f.size / 1000 + " KB " + "<br />";

    // 一件ずつアップロード
    imageFileUpload(files[i]);
    //imageFileUpload(f);
  }
}

// ファイルアップロード
function imageFileUpload(f) {

console.log("file up");

    //var hostUrl= 'https://fnote.com.dev/admin/imagecontrol/';
    var formData = new FormData();
    formData.append('image', f);
    //$.ajax('get_image/', {
    $.ajax({
        //method: 'POST',
        type: 'POST',
        contentType: false,
        processData: false,
        url: 'get_image/',
        data: formData,
        dataType: 'json',
        success: function(data) {
            alert("ok");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           alert("error");
           console.log(XMLHttpRequest);
        }
    });
}

</script>


<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>画像アップロード　　<span class="label label-danger">アドミン</span></h3>
</div>


<div id="image_upload_section">
  <p>ドラッグアンドドロップで1つから複数のファイルのプロパティを取得します。</p>
  <div id="drop" style="width:700px; height:150px; padding:10px; border:3px solid" ondragover="onDragOver(event)" ondrop="onDrop(event)"  >ここにドロップしたファイルのプロパティを読み込みます。</div>
  <p>ファイルプロパティ表示</p>
  <div id="disp" ></div>
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
