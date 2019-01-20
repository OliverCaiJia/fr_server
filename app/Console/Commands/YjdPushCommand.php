<?php

namespace App\Console\Commands;

use App\Helpers\Logger\SLogger;
use App\Models\Factory\Api\UserinfoFactory;
use App\Models\Factory\Api\UserLoanTaskFactory;
use App\Models\Orm\UserLoanTask;
use Illuminate\Console\Command;
use App\Services\Core\Push\Yijiandai\YiJianDaiPushService;
use DB;

class YjdPushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:yjdpush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一键贷数据推送跑批';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        // 防止超时
        set_time_limit(0);
        ignore_user_abort();
        //时区配置
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = 0;
        $count = 100;
        $error_num = 0;
        DB::beginTransaction();

        while (true) {
            $res_task = UserLoanTask::where('status', '=', 1)->skip($start)->take($count)->get()->toArray();

            if (empty($res_task)) {
                break;
            }

            foreach ($res_task as $task_key => $task_val) {
                $request_data = json_decode($res_task[$task_key]['request_data'], true);
                $data = [
                    'mobile' => isset($request_data['mobile']) ? $request_data['mobile'] : '',
                    'name' => isset($request_data['name']) ? $request_data['name'] : '',
                    'certificate_no' => isset($request_data['certificate_no']) ? $request_data['certificate_no'] : '',
                    'sex' => isset($request_data['sex']) ? $request_data['sex'] : '',
                    'birthday' => isset($request_data['birthday']) ? date('Ymd', strtotime($request_data['birthday'])) : '',
                    'has_insurance' => isset($request_data['has_insurance']) ? $request_data['has_insurance'] : '',
                    'house_info' => isset($request_data['house_info']) ? $request_data['house_info'] : '',
                    'car_info' => isset($request_data['car_info']) ? $request_data['car_info'] : '',
                    'occupation' => isset($request_data['occupation']) ? $request_data['occupation'] : '',
                    'salary_extend' => isset($request_data['salary_extend']) ? $request_data['salary_extend'] : '',
                    'salary' => isset($request_data['salary']) ? $request_data['salary'] : '',
                    'accumulation_fund' => isset($request_data['accumulation_fund']) ? $request_data['accumulation_fund'] : '',
                    'work_hours' => isset($request_data['work_hours']) ? $request_data['work_hours'] : '',
                    'business_licence' => isset($request_data['business_licence']) ? $request_data['business_licence'] : '',
                    'has_creditcard' => isset($request_data['has_creditcard']) ? $request_data['has_creditcard'] : '',
                    'social_security' => isset($request_data['social_security']) ? $request_data['social_security'] : '',
                    'is_micro' => isset($request_data['is_micro']) ? $request_data['is_micro'] : '',
                    'city' => isset($request_data['city']) ? $request_data['city'] : '',
                    'money' => isset($request_data['money']) ? $request_data['money'] : '',
                ];
                $yjd_result = YiJianDaiPushService::o()->sendPush($data);
                $yjd_res = json_decode($yjd_result, true);
                SLogger::getStream()->warn('yjd_result', $yjd_res);
                if ($yjd_res['error_code'] == 0) {
                    //update task status
                    $task_data = [
                        'status' => 2,
                        'response_data' => $yjd_result,
                        'update_at' => date('Y-m-d H:i:s')
                    ];
                    $task_up = UserLoanTaskFactory::updateDataById($task_val['id'], $task_data);

                    //update user_info
                    $whereInfo = ['user_id' => $task_val['user_id'], 'service_status' => 3];
                    $userInfo_data = [
                        'service_status' => 4,
                        'update_at' => date('Y-m-d H:i:s')
                    ];
                    $userInfo_up = UserinfoFactory::updateUserInfoData($whereInfo, $userInfo_data);

                    if ($task_up && $userInfo_up !== false) {
                        DB::commit();
                    } else {
                        $error_num++;
                        DB::rollback();
                        SLogger::getStream()->warn('push_error', $data);
                    }
                }
                SLogger::getStream()->warn('error', $data);
            }

            if (count($res_task) < $count) {
                break;
            }
            if ($error_num >= $count) {
                break;
            }
        }
    }
}
