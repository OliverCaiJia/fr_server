var start = {
    elem: "#start",
    format: "YYYY-MM-DD hh:mm:ss",
    max: laydate.now(),
    istime: true,
    istoday: true,
    choose: function (datas) {
        end.min = datas;
        end.start = datas
    }
};
var end = {
    elem: "#end",
    format: "YYYY-MM-DD hh:mm:ss",
    max: laydate.now(),
    istime: true,
    istoday: true,
    choose: function (datas) {
        start.max = datas
    }
};
laydate(start);
laydate(end);
$('#start').val(laydate.now(-30, 'YYYY-MM-DD') + ' 00:00:00');
$('#end').val(laydate.now(0, 'YYYY-MM-DD' + ' 23:59:59'));
