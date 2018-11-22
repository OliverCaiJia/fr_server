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
$.ajaxSetup({
    beforeSend: function (xhr) {
        var $token = '',
            url = $.trim(this.url),
            type = this.type.toUpperCase();
        for (var i = -1, arr = [];
            (i = url.indexOf("?", i + 1)) > -1; arr.push(i));
        if (type == 'GET') {
            if (arr != '') {
                var dataString = url.substring(arr).replace('?', '');
                var url = url.substring(0, arr);
            } else {
                var dataString = "";
            }
        } else {
            var dataString = this.data;
        }
        var $signUrl = hex_sha1(url),
            $dataString = dataString.replace(/=/g, '').split('&').sort().join(''),
            $startString = $dataString.substring(0, 3),
            $endString = $dataString.substring($dataString.length - 3),
            $sha1Text = $startString + $token + $endString + $signUrl,
            $sha1Sign = hex_sha1($sha1Text);
        xhr.setRequestHeader("X-Sign", $sha1Sign);
        xhr.setRequestHeader("X-Token", $token);
    },
    error: function (jqXHR, textStatus, errorMsg) {
        //        console.log(jqXHR)
        //        console.log(textStatus)
        //        console.log(errorMsg)
    }
});
