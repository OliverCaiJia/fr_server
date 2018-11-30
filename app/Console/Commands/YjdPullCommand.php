<?php

namespace App\Console\Commands;

use App\Models\Orm\UserLoanTask;
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
        $taskList = UserLoanTask::join('user_auth','user_loan_task.user_id','=','user_auth.id')
                    ->select('user_loan_task.*','user_auth.mobile')
                    ->where(['user_loan_task.type_id'=>0,'user_loan_task.status'=>1])
                    ->get()
                    ->toArray();
        if(empty($taskList)){
            return ;
        }
        //数据处理
        foreach($taskList as $k=>$v){
            if(strtotime("{$v['create_at']}+30 day") < time()){
                UserLoanTaskFactory::updateStatusById($v['id'],4);
            }else{
                $res = YiJianDaiPushService::o()->getPull(['mobile'=>$v['mobile']]);
                if($res['error_code'] == 0 && !empty($res['data']['list'])){
                    $data['request_data'] = json_encode(['mobile'=>$v['mobile']]);
                    $data['response_data'] = json_encode($res['data']['list']);
                    $data['status'] = 2;
                    $data['send_at'] = date('Y-m-d H:i:s');
                    $data['update_at'] = date('Y-m-d H:i:s');
                    UserLoanTask::where(['id'=>$v['id']])->update($data);
                }
            }
        }
    }
}
