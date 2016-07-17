{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}
    {*include file="../header_gl.tpl" head_index="1"*}



<style type="text/css">
<!--
/*---------------------------------
	 ▼index.php style▼
---------------------------------*/
body#admin #gallery_wrap {
	width:840px;
}


body#admin #gallery_list li{
	width:100px;
	height:140px;
	border:1px solid #ccc;
	float:left;
	margin:0 5px 5px 0;
	overflow:hidden;
	padding:5px;
	text-align:center;
	font-size:12px;
	position:relative;

}
body#admin ul.gallery_list_order li{
	cursor:move;
	padding-top:25px!important;
	height:92px!important;
}
.gallery_list_order li a.button{
	 display:none!important;
}
.hidden_text{
	position:absolute;
	top:50px;
	left:27px;
	color:#F00;
	font-weight:bold;
	font-size:14px;
}
body#admin #gallery_list a{
	display:block;
}
body#admin #gallery_list a.photo{
	width:100px;
	margin:0 auto;
	height:80px;
	overflow:hidden;
}

body#admin #gallery_list a.button{
	padding:3px 5px;
	text-decoration:none;
	color:#fff;
	margin:2px auto;
	background:#555;
	width:90px;
}
body#admin #gallery_list a.button:hover{
	background:#000;
}
body#admin .submit_btn {
	width:240px;
	height:30px;
	cursor:pointer;
}
-->
</style>



</head>


<body id="admin">
<div id="wrapper">
<h2>画像登録・編集フォーム</h2>

<br><br>
{*<form method="post" action="/admin/gallery/gd_new/" enctype="multipart/form-data" name="form">*}
{*form_open('/gallery/gd_new/' , 'name="galleryForm" enctype="multipart/form-data" class="form-horizontal"')*}

{form_open('/gallery/gd_list/' , 'name="listForm" class="form-horizontal"')}
{*<form action="" method="post">*}

<input type="submit" id="submit" value="並び順を保存する" onClick="alert('並べ替え完了です')"/>

<div id="gallery_wrap">
  <ul id="gallery_list" class="sortable">
  {*<ul  class="sortable">*}
      {foreach from=$str_html item=list}

                    {$list}

      {foreachelse}
        画像はありませんでした。
      {/foreach}
  </ul>
</div>


<input type="hidden" id="result" name="result" />
<input type="hidden" name="chg_uniq" value={$chg_uniq} />

{*</form>*}
{form_close()}

<script>
$(function() {
    $(".sortable").sortable();
    $(".sortable").disableSelection();
    $("#submit").click(function() {
        var result = $(".sortable").sortable("toArray");
        $("#result").val(result);
        $("form").submit();
    });
});
</script>



{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
