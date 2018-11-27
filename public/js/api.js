//判断定义请求接口
var host = window.location.host;
var arr = host.split(".");
var host_href = arr[arr.length - 2];
var api_fruitloan_host;
if (host == "api." + host_href + ".com") {
    var fruit_protocol = (("https:" == document.location.protocol) ? "https://" : "http://");
} else {
    var fruit_protocol = (("https:" == document.location.protocol) ? "https://uat." : "http://uat.");
    //    document.write('<script src="/js/vconsole.min.js"></script>');
}
api_fruitloan_host = fruit_protocol + "fruit.witlending.com/api";
//utf-8转utf-16
function utf16to8(str) {
    var out, i, len, c;
    out = "";
    len = str.length;
    for (i = 0; i < len; i++) {
        c = str.charCodeAt(i);
        if ((c >= 0x0001) && (c <= 0x007F)) {
            out += str.charAt(i);
        } else if (c > 0x07FF) {
            out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
            out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F));
            out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
        } else {
            out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));
            out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
        }
    }
    return out;
}
$.ajaxSetup({
    beforeSend: function (xhr) {
        var $token = $('#sign').html() || $('.token').html(),
            url = $.trim(this.url),
            type = this.type.toUpperCase();
        for (var i = -1, arr = [];
            (i = url.indexOf("?", i + 1)) > -1;) {
            arr.push(i);
            break;
        };
        if (type == 'GET') {
            if (arr.length != 0) {
                var dataString = url.substring(arr).replace('?', '');
                var url = url.substring(0, arr);
            } else {
                var dataString = "";
            }
        } else {
            var dataString = decodeURI(this.data);
        }
        var $signUrl = hex_sha1(url),
            dataArr = dataString.split('&'),
            $dataArr = [];
        for (var i = 0; i < dataArr.length; i++) {
            var fir = dataArr[i].indexOf('=');
            var arr = dataArr[i].split('');
            var s = arr.splice(fir, 1);
            var arr1 = arr.join('');
            $dataArr.push(arr1);
        }
        $dataString = $dataArr.sort().join(''), $startString = $dataString.substring(0, 3), $endString = $dataString.substring($dataString.length - 3), $sha1Text = $startString + $token + $endString + $signUrl, $sha1Sign = hex_sha1(utf16to8($sha1Text));
        xhr.setRequestHeader("X-Sign", $sha1Sign);
        xhr.setRequestHeader("X-Token", $token);
    },
    error: function (jqXHR, textStatus, errorMsg) {
        base.popupCover({
            content: '服务器繁忙，请稍后重试！'
        })
    }
});
