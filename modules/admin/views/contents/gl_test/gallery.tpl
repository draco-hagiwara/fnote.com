{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}


        <link rel="stylesheet" type="text/css" href="{base_url()}../../js/gallery/lightbox/jquery.lightbox-0.5.css"/>
        <title>画像アップロードギャラリー</title>
        <!-- サムネイルを見やすく -->
        <style type="text/css"">
         .image-link {
             display: inline-block;
             padding: 2px;
             margin: 0 0.5rem 1rem 0.5rem;
             background-color: #fff;
             line-height: 0;
             border-radius: 4px;
             transition: background-color 0.5s ease-out; }
         .image-link:hover {
             background-color: #4ae;
             transition: none; }
        </style>


<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>画像管理　テスト</h3>
</div>



        <section id="upform" class="upform">
            <h1>アップロードする画像を選択してください</h1>
            <form id="upload-form">
                <input id="ufiles" type="file" name="ufiles[]" accept="image/*" multiple>
            </form>
            <br>
            <hr>
        </section>
        <section id="gallery" class="gallery">
            <h1>アップロード画像一覧</h1>
            <h3>クリックすると拡大表示されます</h3>
            <div id="views" class="views"></div>
        </section>

       <script>
        $(function(){
            //ページロード時の呼び出し
            domout("gallery.php", ".views");

           // id="ufile"の変化でコールバック
            $("#ufiles").change(function(){
                // 選択ファイルの有無をチェック
                if (!this.files.length) {
                    alert('ファイルが選択されていません');
                    return;
                }

                // FormDataを用意
                var fd = new FormData();
                fd.append('action','upload-form');
                $.each($("input[type='file']")[0].files, function(i, file) {
                    fd.append('ufiles['+i+']', file);
                });

                // ajaxでFromDataを送信
                $.ajax({
                    url: 'uploader_m.php',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    dataType: 'html',
                    data: fd
                }).done(function(data, textStatus, jwXHR){
                    alert(data);
                    //終了時の呼び出し
                    domout("gallery.php", ".views");
                }).fail(function(jqXHR, textStatus, errorThrown){
                    alert('エラーが発生しました : ' + textStatus
                        + "\nHTTP status : " + errorThrown);
                });
            });
        });

        // DOMへhtmlを出力
        function domout(_url, _html) {
            $.get(_url, function(data) {
                $(_html).html(data);
            });
        }

       </script>
       <!-- lightbox用JS -->
       <script type="text/javascript" src="{base_url()}../../js/gallery/lightbox/jquery.lightbox-0.5.min.js"></script>
    </body>




{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
