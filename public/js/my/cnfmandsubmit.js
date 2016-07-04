/*
 *  ../modules/admin/views/contents/admin/entrylist/detail.tpl 呼び出し
 */
function cnfmAndSubmit() {
  if (window.confirm('更新します。')) {
    //document.EntryorderForm.submit();
    document.OrderForm.submit();
  } else {
    return false;
  }
}
