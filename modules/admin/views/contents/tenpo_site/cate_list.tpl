{* ヘッダー部分　START *}
    {include file="../header_pre.tpl" head_index="1"}

<body>

<H3><p class="bg-info">カテゴリ・リスト</p></H3>

  <div class="form-group">
    {foreach from=$catelist item=cate name="seq"}
            {*$smarty.foreach.seq.iteration*}
            {$cate}<br>
    {foreachelse}
      リストはありません。
    {/foreach}
  </div>


<br><br>
<div class="panel panel-default">
  <div class="panel-footer text-center">
    Copyright(C) 2016 - {{$smarty.now|date_format:"%Y"}} Themis Inc. All Rights Reserved.
  </div>
</div>

</body>
</html>
