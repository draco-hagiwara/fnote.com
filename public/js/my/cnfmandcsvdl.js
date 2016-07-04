/*
 *  CSVダウンロード用
 */
function cnfmAndcsvdown() {
  if (window.confirm('CSVダウンロードします。')) {
    document.searchForm.submit();
  } else {
    return false;
  }
}
