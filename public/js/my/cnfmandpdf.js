/*
 *  CSVダウンロード用
 */
function cnfmAndpdf() {
  if (window.confirm('ＰＤＦファイルを作成します。')) {
    document.searchForm.submit();
  } else {
    return false;
  }
}
