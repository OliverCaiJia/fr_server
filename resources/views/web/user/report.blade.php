<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report/report.css') }}">
    <title>水果贷-信用报告</title>
</head>

<body>
<div class="container">
    <div class="banner">
        @if(isset($data['report_code']))
            <h3>报告编号:{{ $data['report_code'] }} </h3>
        @endif
        @if(isset($data['create_at']))
            <p>生成时间:{{ $data['create_at'] }}</p>
        @endif
    </div>
    <div class="main">
        <section>
            <h3>基本信息</h3>
            <p><span>姓名：@if(isset($data['name'])){{ $data['name'] }}@endif</span>   <span>年龄：@if(isset($data['age'])){{ $data['age'] }}岁@endif</span></p>
            <p><span>性别：@if(isset($data['gender'])){{ $data['gender'] }}@endif</span>   <span>学历：@if(isset($data['level'])){{ $data['level'] }}@endif</span></p>
            <p>身份证号码：@if(isset($data['idcard'])){{ $data['idcard'] }}@endif</p>
            <p>身份证归属地：@if(isset($data['idcard_location'])){{ $data['idcard_location'] }}@endif</p>
            <p>手机号码：@if(isset($data['mobile'])){{ $data['mobile'] }} @endif</p>
            <p>手机所属运营商：@if(isset($data['carrier'])){{ $data['carrier'] }}@endif</p>
            <p>手机号码归属地：@if(isset($data['mobile_location'])){{ $data['mobile_location'] }}@endif</p>
        </section>
        <section>
            <h3>风险信息</h3>
            <p></p>
        </section>
        <section>
            <h3>法院失信</h3>
            <p>法院执行人次数：@if(isset($data['courtcase_cnt'])){{ $data['courtcase_cnt'] }}次@endif</p>
            <p>失信未执行次数：@if(isset($data['dishonest_cnt'])){{ $data['dishonest_cnt'] }}次@endif</p>
        </section>
        <section>
            <h3>欺诈风险名单</h3>
            <p>风险名单是否命中：@if(isset($data['is_hit'])){{ $data['is_hit'] }}@endif</p>
            <p>命中的欺诈类型：@if(isset($data['type'])){{ $data['type'] }}@endif</p>
        </section>
        <section>
            <h3>多头信息</h3>
            <p>注册机构数：@if(isset($data['org_count'])){{ $data['org_count'] }}@endif</p>
            <p>注册机构类型：@if(isset($data['org_types'])){{ $data['org_types'] }}@endif</p>
            <p>借贷机构数：@if(isset($data['loan_org_cnt'])){{ $data['loan_org_cnt'] }}@endif</p>
            <p>借贷次数：@if(isset($data['loan_cnt'])){{ $data['loan_cnt'] }}次@endif</p>
        </section>
        <section>
            <h3>黑名单</h3>
            <p>姓名和身份证是否在黑名单：@if(isset($data['idcard_name_in_blacklist'])){{ $data['idcard_name_in_blacklist'] }}@endif</p>
            <p>姓名和手机号是否在黑名单：@if(isset($data['mobile_name_in_blacklist'])){{ $data['mobile_name_in_blacklist'] }}@endif</p>
        </section>
        <section>
            <h3>信用卡违约</h3>
            <p>有过逾期的卡片数：@if(isset($data['overdue_card'])){{ $data['overdue_card'] }}@endif</p>
            <p>账单总数：@if(isset($data['bill_nums'])){{ $data['bill_nums'] }}@endif</p>
            <p>最大逾期金额：@if(isset($data['max_overdue_money'])){{ $data['max_overdue_money'] }}@endif</p>
        </section>
        <section>
            <h3>贷后行为</h3>
            <p>近12个月非超短期现金贷累计逾期天数：@if(isset($data['sum_sure_due_days_non_cdq_all_time_m12'])){{ $data['sum_sure_due_days_non_cdq_all_time_m12'] }}@endif</p>
            <p>近12个月累计还款笔数：@if(isset($data['sum_pay_cnt_all_pro_all_time_m12'])){{ $data['sum_pay_cnt_all_pro_all_time_m12'] }}@endif</p>
            <p>近12个月最大逾期借贷最大天数：@if(isset($data['dd_jiedai_max_fail_days_m12'])){{ $data['dd_jiedai_max_fail_days_m12'] }}@endif</p>
        </section>
        <section>
            <h3>电商</h3>
            <p>芝麻分：@if(isset($data['zm_score'])){{ $data['zm_score'] }}@endif</p>
            <p>花呗额度：@if(isset($data['huabai_limit'])){{ $data['huabai_limit'] }}@endif</p>
            <p>借呗额度：@if(isset($data['credit_amt'])){{ $data['credit_amt'] }}@endif</p>
        </section>
        <div class="btm-tips">信用报告数据说明:
            <p>信用报告由本人授权查询，速贷信用只做大数据信息的获取及分析，不对原始数据做任何修改，信用报告仅供本人或本人授权同意下的使用方参考使用。</p>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
</body>

</html>
