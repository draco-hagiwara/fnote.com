/*
 *  CSVダウンロード用
 */
function cnfmAndcsvup() {
  if (window.confirm('CSVアップロードします。')) {
    document.searchForm.submit();
  } else {
    return false;
  }
}
