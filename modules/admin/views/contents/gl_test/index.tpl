{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}


<script>
$(function() {
    //画像アップロード
    $("#file").change(function() {
        $(this).closest("form").submit();
    });
    //画像削除
    $("#close").click(function() {
        area = $('[type="checkbox"]:checked').map(function(){
          return 'area[]=' + $(this).val();
        }).get().join('&');

        $.ajax({
            url: '/admin/gl_test/',
            type: 'post',
            data: {
                checked: area
            },
            timeout: 10000,
            dataType: 'json',
            cache: false,
            complete: function(xhr, textStatus) {
                location.href = "/admin/gl_test?delete=1";
            }
        });
    });
});
</script>


<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>画像管理　テスト</h3>
</div>



<form action="/admin/gl_test/" method="POST" name="form" enctype="multipart/form-data">

    <button type="button" onclick="$('#file').click();" >アップロード</button>
    <button type="button" id="close" >デリート</button>


    <div class="hoge">
        <div class="box-img">
            <img src="/gl_image/20160711_538475783426e598ee.jpg">
        </div>
        <p class="center">20160711_538475783426e598ee.jpg</p>
        <label class="checkbox"><input type="checkbox" name="check[]" value="20160711_538475783426e598ee.jpg"></label>
    </div>

    <div class="hoge">
        <div class="box-img">
            <img src="/gl_image/thumb_20160711_538475783426e598ee.jpg">
        </div>
        <p class="center">thumb_20160711_538475783426e598ee.jpg</p>
        <label class="checkbox"><input type="checkbox" name="check[]" value="thumb_20160711_538475783426e598ee.jpg"></label>
    </div>

    <div class="hoge">
        <div class="box-img">
            <img src="/gl_image/entry1.jpg">
        </div>
        <p class="center">entry1.jpg</p>
        <label class="checkbox"><input type="checkbox" name="check[]" value="entry1.jpg"></label>
    </div>


    <input type="file" id="file" name="file" accept=".jpg,.png" style="display:none;" onchange="$('#file').click();"/>
</form>





{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
