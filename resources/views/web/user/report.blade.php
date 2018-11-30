<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report/report.css') }}">
    <title>水果贷-信用报告</title>
</head>

<body>
    <div class="container">
        <div class="banner">
            <h3>报告编号:{{ $data['report_code'] }} </h3>
            <p>生成时间:{{ $data['create_at'] }}</p>
        </div>
        <div class="main">
            <section>
                <h3>基本信息</h3>
                <p><span>姓名：{{ $data['name'] }}</span><span>年龄：{{ $data['age'] }}岁</span></p>
                <p><span>性别：{{ $data['gender'] }}</span><span>学历：{{ $data['level'] }}</span></p>
                <p>身份证号码：{{ $data['idcard'] }}</p>
                <p>身份证归属地：{{ $data['idcard_location'] }}</p>
                <p>手机号码：{{ $data['mobile'] }} </p>
                <p>手机所属运营商：{{ $data['carrier'] }}</p>
                <p>手机号码归属地：{{ $data['mobile_location'] }}</p>
            </section>
            <section>
                <h3>风险信息</h3>
                <p></p>
            </section>
            <section>
                <h3>法院失信</h3>
                <p>法院执行人次数：{{ $data['courtcase_cnt'] }}次</p>
                <p>失信未执行次数：{{ $data['dishonest_cnt'] }}次</p>
            </section>
            <section>
                <h3>欺诈风险名单</h3>
                <p>风险名单是否命中：{{ $data['is_hit'] }}</p>
                <p>命中的欺诈类型：{{ $data['type'] }}</p>
            </section>
            <section>
                <h3>多头信息</h3>
                <p>注册机构数：{{ $data['org_count'] }}</p>
                <p>注册机构类型：{{ $data['org_types'] }}</p>
                <p>借贷机构数：{{ $data['loan_org_cnt'] }}</p>
                <p>借贷次数：{{ $data['loan_cnt'] }}次</p>
            </section>
            <section>
                <h3>黑名单</h3>
                <p>姓名和身份证是否在黑名单：{{ $data['idcard_name_in_blacklist'] }}</p>
                <p>姓名和手机号是否在黑名单：{{ $data['mobile_name_in_blacklist'] }}</p>
            </section>
            <section>
                <h3>信用卡违约</h3>
                <p>有过逾期的卡片数：{{ $data['overdue_card'] }}</p>
                <p>账单总数：{{ $data['bill_nums'] }}</p>
                <p>最大逾期金额：{{ $data['max_overdue_money'] }}</p>
            </section>
            <section>
                <h3>贷后行为</h3>
                <p>近12个月非超短期现金贷累计逾期天数：{{ $data['sum_sure_due_days_non_cdq_all_time_m12'] }}</p>
                <p>近12个月累计还款笔数：{{ $data['sum_pay_cnt_all_pro_all_time_m12'] }}</p>
                <p>近12个月最大逾期借贷最大天数：{{ $data['dd_jiedai_max_fail_days_m12'] }}</p>
            </section>
            <section>
                <h3>电商</h3>
                <p>芝麻分：{{ $data['zm_score'] }}</p>
                <p>花呗额度：{{ $data['huabai_limit'] }}</p>
                <p>借呗额度：{{ $data['credit_amt'] }}</p>
            </section>
            <div class="btm-tips">信用报告数据说明:
                <p>信用报告由本人授权查询，速贷信用只做大数据信息的获取及分析，不对原始数据做任何修改，信用报告仅供本人或本人授权同意下的使用方参考使用。</p>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
</body>

</html>
