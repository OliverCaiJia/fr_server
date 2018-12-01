<?php

namespace App\Http\Controllers\Web\V1;

use App\Helpers\Logger\SLogger;
use App\Models\Factory\Api\UserBasicFactory;
use App\Models\Factory\Api\UserReportFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\WebController;

class UserController extends WebController
{

    public function report(Request $request)
    {
        //获取用户数据
        $data = [];
        $user_id = $this->getUserId($request);
        $resData = UserReportFactory::getReportByUserId($user_id);
        $reportData = json_decode($resData['report_data'], true);

        //组装数据
        $data['report_code'] = $resData['report_code']; //报告编号
        $data['create_at'] = $resData['create_at']; //生成时间

        $data['name'] = isset($reportData['post_load']['person_info']['name']) ?: null; //姓名
        $data['gender'] = isset($reportData['post_load']['person_info']['gender']) ?: null; //性别
        $data['age'] = isset($reportData['post_load']['person_info']['age']) ?: null; //年龄
        //学历
        switch ($reportData['post_load']['person_info']['education_info']['level']) {
            case 0:
                $data['level'] = '未知';
                break;
            case 1:
                $data['level'] = '专科';
                break;
            case 2:
                $data['level'] = '本科';
                break;
            case 3:
                $data['level'] = '硕士研究生';
                break;
            case 4:
                $data['level'] = '博士研究生';
                break;
            case 5:
                $data['level'] = '预科';
                break;
            case 6:
                $data['level'] = '夜大/电大/函大';
                break;
            default:
                $data['level'] = '未知';
        }
        $data['idcard'] = isset($reportData['post_load']['person_info']['idcard']) ?: null; //身份证号
        $data['idcard_location'] = isset($reportData['post_load']['person_info']['idcard_location']) ?: null; //身份证归属地
        $data['mobile'] = isset($reportData['post_load']['person_info']['mobile']) ?: null; //手机号
        $data['carrier'] = isset($reportData['post_load']['person_info']['carrier']) ?: null; //手机运营商
        $data['mobile_location'] = isset($reportData['post_load']['person_info']['mobile_location']) ?: null; //手机号码归属地

        $data['courtcase_cnt'] = isset($reportData['anti_fraud']['untrusted_info']['courtcase_cnt']) ?: null; //法院执行人次数
        $data['dishonest_cnt'] = isset($reportData['anti_fraud']['untrusted_info']['dishonest_cnt']) ?: null; //失信未执行次数
        $data['is_hit'] = $reportData['anti_fraud']['fraudulence_info']['is_hit'] ? '是' : '否'; //欺诈风险名单是否命中
        $data['type'] = empty($reportData['anti_fraud']['fraudulence_info']['type']) ? '无' : $reportData['anti_fraud']['fraudulence_info']['type']; //欺诈风险名单类型

        $data['org_count'] = isset($reportData['multi_info']['auth_queried_detail']['register_info']['org_count']) ?: null; //注册机构数量
        $org_types = $reportData['multi_info']['auth_queried_detail']['register_info']['org_types']; //注册机构类型
        if (!empty($org_types)) {
            foreach ($org_types as $k => $v) {
                switch ($v) {
                    case 'ZHENGXIN':
                        $data['org_types'][] = '信用机构';
                        break;
                    case 'DATACOVERGE':
                        $data['org_types'][] = '数据平台';
                        break;
                    case 'BANK':
                        $data['org_types'][] = '银行';
                        break;
                    case 'CUSTOMER_FINANCE':
                        $data['org_types'][] = '消费金融';
                        break;
                    case 'CASH_LOAN':
                        $data['org_types'][] = '现金贷';
                        break;
                    case 'P2P':
                        $data['org_types'][] = 'P2P理财';
                        break;
                    case 'CREDITPAY':
                        $data['org_types'][] = '信用支付';
                        break;
                    case 'CONSUMSTAGE':
                        $data['org_types'][] = '消费分期';
                        break;
                    case 'COMPENSATION':
                        $data['org_types'][] = '信用卡代偿';
                        break;
                    case 'DIVERSION':
                        $data['org_types'][] = '导流平台';
                        break;
                    case '其他':
                        $data['org_types'][] = '其他';
                        break;
                    default:
                        $data['org_types'][] = '其他';
                }
            }
            $data['org_types'] = implode(',', $data['org_types']);
        } else {
            $data['org_types'] = '无';
        }

        $data['loan_org_cnt'] = isset($reportData['multi_info']['auth_queried_detail']['loan_info']['loan_org_cnt']) ?: null; //借贷机构数
        $data['loan_cnt'] = isset($reportData['multi_info']['auth_queried_detail']['loan_info']['loan_cnt']) ?: null; //借贷次数

        $data['idcard_name_in_blacklist'] = $reportData['black_gray']['black_info_detail']['idcard_name_in_blacklist'] ? '是' : '否'; //身份证和姓名是否在黑名单
        $data['mobile_name_in_blacklist'] = $reportData['black_gray']['black_info_detail']['mobile_name_in_blacklist'] ? '是' : '否'; //手机和姓名是否在黑名单

        $data['overdue_card'] = isset($reportData['application']['credit_card']['overdue_card']) ?: null; //有过逾期的卡片数
        $data['bill_nums'] = isset($reportData['application']['credit_card']['bill_nums']) ?: null; //账单总数
        $data['max_overdue_money'] = empty($reportData['application']['credit_card']['max_overdue_money']) ? 0 : $reportData['application']['credit_card']['max_overdue_money']; //最大逾期金额

        $data['sum_sure_due_days_non_cdq_all_time_m12'] = empty($reportData['post_load']['loan_behavior_analysis']['feature_360d']['sum_sure_due_days_non_cdq_all_time_m12']) ? 0 : $reportData['post_load']['loan_behavior_analysis']['feature_360d']['sum_sure_due_days_non_cdq_all_time_m12']; //近12个月非超短期现金贷累计逾期天数
        $data['sum_pay_cnt_all_pro_all_time_m12'] = empty($reportData['post_load']['loan_behavior_analysis']['feature_360d']['sum_pay_cnt_all_pro_all_time_m12']) ? 0 : $reportData['post_load']['loan_behavior_analysis']['feature_360d']['sum_pay_cnt_all_pro_all_time_m12']; //近12个月累计还款笔数
        $data['dd_jiedai_max_fail_days_m12'] = empty($reportData['post_load']['loan_behavior_analysis']['feature_360d']['dd_jiedai_max_fail_days_m12']) ? 0 : $reportData['post_load']['loan_behavior_analysis']['feature_360d']['dd_jiedai_max_fail_days_m12']; //近12个月最大逾期借贷最大天数

        $data['zm_score'] = empty($reportData['credit_qualification']['qualification_info']['zm_score_info']['zm_score']) ? '未知' : $reportData['credit_qualification']['qualification_info']['zm_score_info']['zm_score']; //芝麻分
        $data['huabai_limit'] = empty($reportData['credit_qualification']['qualification_info']['huabei_info']['huabai_limit']) ? '未知' : $reportData['credit_qualification']['qualification_info']['huabei_info']['huabai_limit']; //花呗额度
        $data['credit_amt'] = empty($reportData['credit_qualification']['qualification_info']['jiebei_info']['credit_amt']) ? '未知' : $reportData['credit_qualification']['qualification_info']['jiebei_info']['credit_amt']; //借呗额度

        return view('web.user.report', compact('data'));
    }

    public function createReport()
    {
        return view('web.user.createreport');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userinfo(Request $request)
    {
        $user_id = $this->getUserId($request);
        $data = UserBasicFactory::fetchUserBasic($user_id);
        $token = $this->getToken($request);

        if (empty($data)) {
            return view('web.user.userinfo', compact('data', 'token'));
        }
        switch ($data['profession']) {
            case 0:
                $data['profession'] = '上班族';
                break;
            case 1:
                $data['profession'] = '企业主';
                break;
            case 2:
                $data['profession'] = '自由职业';
        }

        switch ($data['work_time']) {
            case 0:
                $data['work_time'] = '半年内';
                break;
            case 1:
                $data['work_time'] = '一年以内';
                break;
            case 2:
                $data['work_time'] = '一年以上';
        }

        switch ($data['month_salary']) {
            case 0:
                $data['month_salary'] = '2千以下';
                break;
            case 1:
                $data['month_salary'] = '2千-5千';
                break;
            case 2:
                $data['month_salary'] = '5千-1万';
                break;
            case 4:
                $data['month_salary'] = '1万以上';
                break;
        }

        switch ($data['house_fund_time']) {
            case 0:
                $data['house_fund_time'] = '无公积金';
                break;
            case 1:
                $data['house_fund_time'] = '一年以内';
                break;
            case 2:
                $data['house_fund_time'] = '一年以上';
                break;
        }
        return view('web.user.userinfo', compact('data', 'token'));
    }
}
