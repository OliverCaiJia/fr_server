<?php

namespace App\Console\Commands;

use App\Models\Factory\Api\UserLoanFactory;
use App\Models\Factory\Api\UserLoanLogFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserAuth;
use App\Models\Orm\UserLoanLog;
use App\Models\Orm\UserLoanTask;
use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Factory\Api\UserLoanTaskFactory;
use App\Services\Core\Push\Yijiandai\YiJianDaiPushService;

class YjdPullCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:yjdpull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一键贷推送结果';

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
     * @return mixed
     * 一键贷推送结果获取
     */
    public function handle()
    {
        //获取已发送任务
        $params['type_id'] = 0;
        $params['status'] = 2;
        $taskList = UserLoanTaskFactory::getTasksAndUserMobile($params);
        if(empty($taskList)){
            return ;
        }
        //数据处理
        foreach($taskList as $k=>$v){
            if(strtotime("{$v['create_at']}+30 day") < time()){
                UserLoanTaskFactory::updateStatusById($v['id'],9);
            }else{
                //获取订单信息
                $data = UserOrderFactory::getOrderDetailByOrderNo($v['loan_order_no']);

                //定义接口参数
                $sendParams['mobile'] = $v['mobile'];
                $res = YiJianDaiPushService::o()->getPull($sendParams);

                //组合参数
                $data['task_id'] = $v['id'];
                $data['request_data'] = json_encode($sendParams);
                $data['response_data'] = json_encode($res['data']['list']);
                $data['status'] = 3;
                $data['platform_id'] = 1;

                //记录loan_log
                UserLoanLogFactory::createUserLoanLog($data);

                //更新数据
                if($res['error_code'] == 0 && !empty($res['data']['list'])){
                    //更新loan_task
                    UserLoanTaskFactory::updateTaskResult($data);
                    //记录loan
                    foreach($res['data']['list'] as $res_key=>$res_val){
                        $data['res_status'] = $res_val['status'];
                        UserLoanFactory::createUserLoan($data);
                    }
                }
            }
        }
    }
}
