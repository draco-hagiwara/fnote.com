$.jPrintArea = function (el) {
    var iframe = document.createElement('IFRAME');
    iframe.src = "javascript:false;";
    var doc = null;
    $(iframe).attr('id', 'print_preview');
    $(iframe).attr('style', 'position:absolute;width:0px;height:0px;left:-500px;top:-500px;');
    document.body.appendChild(iframe);
    doc = iframe.contentWindow.document;
    var links = window.document.getElementsByTagName('link');
    for (var i = 0; i < links.length; i++) {
        if (links[i].rel.toLowerCase() == 'stylesheet') {
            doc.write('<link type="text/css" rel="stylesheet" href="' + $(links[i]).prop('href') + '"></link>');
        }
    }
    $(el).each(function(){
        doc.write('<div class="' + $(this).attr("class") + '">' + $(this).html() + '</div>');
    });
    doc.close();
 
    function output_preview(){
        iframe = document.getElementById('print_preview');
        iframe.contentWindow.focus();
        setTimeout(function(){
            iframe.contentWindow.print();
            document.body.removeChild(iframe);
        }, 100);
    }
    timerId = setTimeout(output_preview);
};
