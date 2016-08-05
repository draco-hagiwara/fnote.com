{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}



<link href="../../wysiwyg/css/font-awesome.css" rel="stylesheet" />
<link href="../../wysiwyg/css/bootstrap-combined.min.css" rel="stylesheet" />

{*

<link href="../../wysiwyg/css/style.css" rel="stylesheet" />
*}


<script src="../../wysiwyg1/js/bootstrap-wysiwyg.js"></script>
<script src="../../wysiwyg1/js/jquery.hotkeys.js"></script>

{*
<script src="../../wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="../../wysiwyg/js/bootstrap.min.js"></script>

*}


<style type="text/css">
<!--
body {
    background-color: rgb(240, 245, 250);
}
#editor {
    overflow:scroll;
    min-height: 100px;
    width: 90%;
    background-color: white;
    line-height: 20px;
}
-->
</style>



<body>
{* ヘッダー部分　END *}






<p class="bg-info">　■　投稿一覧</p>

{form_open('blog/detail/' , 'name="blogForm" class="form-horizontal"')}

<ul class="pagination pagination-sm">
    登録件数： {$countall}件<br />
    {$set_pagination}
</ul>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>日時</th>
                <th>題名</th>
                <th>ステータス</th>
                <th></th>
            </tr>
        </thead>


        {foreach from=$list item=nw  name="seq"}
        <tbody>
            <tr>
                <td>
                    {$smarty.foreach.seq.iteration}
                </td>
                <td>
                    {if $nw.nw_status == "0"}<font color="#ffffff" style="background-color:blue">表　示</font>
                    {elseif $nw.nw_status == "1"}<font color="#ffffff" style="background-color:gray">非表示</font>
                    {else}エラー
                    {/if}
                </td>
                <td>
                    {if $nw.nw_type == "0"}<font color="#ffffff" style="background-color:#CC00FF">新着情報</font>
                    {elseif $nw.nw_type == "1"}<font color="#ffffff" style="background-color:#66CC33">お知らせ</font>
                    {else}エラー
                    {/if}
                </td>
                <td>
                    {$nw.nw_start_date}
                </td>
                <td>
                    <button type="submit" class="btn btn-success btn-xs" name="chg_uniq" value="{$nw.nw_seq}">編集</button>
                </td>
            </tr>
        </tbody>
        {foreachelse}
            検索結果はありませんでした。
        {/foreach}

    </table>

{form_close()}





<br><br><br>
<p class="bg-info">　■　新規投稿・編集/削除</p>


{form_open('blog/detail/' , 'name="blogdetailForm" class="form-horizontal"')}

  <div class="form-group">
    <label for="bar_subject" class="col-sm-1 control-label">題名</label>
    <div class="col-sm-5">
      {form_input('bar_subject' , set_value('bar_subject', $low.bar_subject) , 'class="form-control" placeholder="題名を入力してください"')}
      {if form_error('bar_subject')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bar_subject')}</font></label>{/if}
    </div>
  </div>
  <div class="form-group">
    <label for="bar_tag" class="col-sm-1 control-label">タグ</label>
    <div class="col-sm-2">
      {form_input('bar_tag' , set_value('bar_tag', $low.bar_tag) , 'class="form-control" placeholder="タグ（カンマ「，」区切り）を入力してください"')}
      {if form_error('bar_tag')}<span class="label label-danger">Error : </span><label><font color=red>{form_error('bar_tag')}</font></label>{/if}
    </div>
  </div>

  <div class="radio">
    <label class="col-sm-1 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios1" value="0" checked>コメント受付あり
    </label>
    <label>
      <input type="radio" name="optionsRadios01" id="optionsRadios2" value="1">コメント受付なし
    </label>
  </div>

  <div class="radio">
    <label class="col-sm-1 control-label"></label>
    <label>
      <input type="radio" name="optionsRadios02" id="optionsRadios1" value="0" checked>公開
    </label>
    <label>
      <input type="radio" name="optionsRadios02" id="optionsRadios2" value="1">非公開
    </label>
  </div>

  <br><br>






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

  <div id="editor" contenteditable="true"></div>


<script type='text/javascript'>
  $('#editor').wysiwyg();
</script>






  {form_hidden('nw_seq', $nw_seq)}

  <br><br>
  <!-- Button trigger modal -->
  <div class="row">
  <div class="col-sm-2 col-sm-offset-4">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal01">登録 or 編集</button>
  </div>
  <div class="col-sm-2 col-sm-offset-1">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal02">削除する</button>
  </div>
  </div>

  <div class="modal fade" id="myModal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">新着・お知らせ情報　更新</h4>
        </div>
        <div class="modal-body">
          <p>更新しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='submit' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <div class="modal fade" id="myModal02" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">新着・お知らせ情報　削除</h4>
        </div>
        <div class="modal-body">
          <p>削除しますか。&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type='submit' name='submit' value='delete' class="btn btn-sm btn-primary">O  K</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">キャンセル</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->




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
