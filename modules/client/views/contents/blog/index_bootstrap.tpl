{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}



<link href="../../wysiwyg/css/style.css" rel="stylesheet" />
<link href="../../wysiwyg/css/bootstrap-combined.min.css" rel="stylesheet" />
<link href="../../wysiwyg/css/font-awesome.css" rel="stylesheet" />

<script src="../../wysiwyg/js/bootstrap.min.js"></script>
<script src="../../wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="../../wysiwyg/js/jquery.hotkeys.js"></script>
<script src="../../wysiwyg/src/bootstrap-wysiwyg.js"></script>




<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>ログイン TOP画面　　<span class="label label-danger">クライアント</span></h3>
</div>

<p class="bg-info">　■　投稿一覧</p>

{form_open('news/' , 'name="newsForm" class="form-horizontal"')}

<select multiple class="form-control">

  <option>
    {$list.nw_status}{$list.nw_open_date}{$list.nw_title}
    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/admin/clientlist/detail/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">編 集</button>
    <button type="button" class="btn btn-success btn-xs" onclick="fmSubmit('detailForm', '/admin/clientlist/detail/', 'POST', '{$cl.cl_seq}', 'chg_uniq');">削除</button>
  </option>

  {form_hidden('nw_seq', $list.nw_seq)}

</select>

{form_close()}






{form_open('news/detail/' , 'name="newsdetailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="cl_fax" class="col-sm-4 control-label">タイトル</label>
    <div class="col-sm-8">
      {form_input('cl_fax' , set_value('cl_fax', '') , 'class="form-control" placeholder="タイトルを入力してください"')}
      {if form_error('cl_fax')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('cl_fax')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="nw_open_date_yy" class="col-sm-4 control-label">日付年</label>
    <div class="col-sm-8">
      {form_input('nw_open_date_yy' , set_value('nw_open_date_yy', '') , 'class="form-control" placeholder="日付年を入力してください"')}
      {if form_error('nw_open_date_yy')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('nw_open_date_yy')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="nw_open_date_mm" class="col-sm-4 control-label">日付月</label>
    <div class="col-sm-8">
      {form_input('nw_open_date_mm' , set_value('nw_open_date_mm', '') , 'class="form-control" placeholder="日付月を入力してください"')}
      {if form_error('nw_open_date_mm')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('nw_open_date_mm')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="nw_open_date_dd" class="col-sm-4 control-label">日付日</label>
    <div class="col-sm-8">
      {form_input('nw_open_date_dd' , set_value('nw_open_date_dd', '') , 'class="form-control" placeholder="日付日を入力してください"')}
      {if form_error('nw_open_date_dd')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('nw_open_date_dd')}</font></label>{/if}
    </div>
  </div>







<div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="icon-font"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
        </div>
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
        <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
        <a class="btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="icon-strikethrough"></i></a>
        <a class="btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="icon-list-ul"></i></a>
        <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="icon-list-ol"></i></a>
        <a class="btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
        <a class="btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="icon-indent-right"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
        <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
        <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
        <a class="btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
      </div>
      <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="icon-link"></i></a>
        <div class="dropdown-menu input-append">
          <input class="span2" placeholder="URL" type="text" data-edit="createLink">
          <button class="btn" type="button">Add</button>
        </div>
        <a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="icon-cut"></i></a>

      </div>

      <div class="btn-group">
        <a class="btn" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="icon-picture"></i></a>
        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 36px; height: 30px;">
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
        <a class="btn" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
      </div>
      <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" style="position: absolute; top: 280px; left: 864px;">
</div>


<script type='text/javascript'>
  $('#editor').wysiwyg();
</script>



  {*form_hidden('nw_seq', $list.nw_seq)*}


{form_close()}








<!-- </form> -->



<br><br><br>
{* フッター部分　START *}
    <!-- Bootstrapのグリッドシステムclass="row"で終了 -->
    </div>
  </section>
</div>

{include file="../footer.tpl"}
{* フッター部分　END *}

</body>
</html>
