{* ヘッダー部分　START *}
    {include file="../header.tpl" head_index="1"}



<body>
{* ヘッダー部分　END *}

<div class="jumbotron">
  <h3>画像管理　　<span class="label label-danger">アドミン</span></h3>
</div>


	<p>
		・アップロード画像の削除<br />
		・記事ヘッダー画像としての使用<br />
	</p>
	<p>設定内容を変更される場合は、内容記入の上、ページ下の「一括処理」ボタンを押してください。</p>

	<form action="/admin/imagecontrol/manage/" method="post" />
		<table>
		<tr>
			<td>NO</td>
			<td>サムネイル</td>
			<td>ヘッダー使用</td>
			<td>画像情報</td>
			<td>IMGタグ</td>
			<td>削除</td>
		</tr>


		{section name=item loop=$list}
		<tr>
			<td>{$list[item].im_seq}</td>
			<td width="120" height="120" align="center">
				<a href="/images/{$list[item].im_cl_siteid}/entry{$list[item].im_seq}.{$list[item].im_type}" target="_blank">
				<img src="/images/{$list[item].im_cl_siteid}/entry{$list[item].im_seq}.{$list[item].im_type}" /></a>
			</td>
			<td>{if $list[item].im_is_header == 1}<input type="radio" name="form[header]" value="{$list[item].im_seq}" checked>
			    {else}<input type="radio" name="form[header]" value="{$list[item].im_seq}">
			    {/if}
			</td>
			<td>UPLODE: {$list[item].im_update_date}<br />
			SIZE: {$list[item].im_size} KB<br />
			WH: {$list[item].im_width} x {$list[item].im_height}
			</td>
			<td><input type="text" size="20" value="<img src=/images/{$list[item].im_cl_siteid}/entry{$list[item].im_seq}.{$list[item].im_type} width=1024 height=768 alt= />" /></td>
			<td><input type="checkbox" name="form[delete][{$list[item].im_seq}]" value="1" /></td>
		</tr>
		{/section}


		<input type="hidden" name="cl_siteid" value={$cl_siteid} />
		<input type="hidden" name="mode" value="edit" />

		<tr><td colspan="7" align="right"><input type="submit" value="一括処理" /></td></tr>
		</table>
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
