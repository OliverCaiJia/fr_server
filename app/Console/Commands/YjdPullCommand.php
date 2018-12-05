<?php

namespace App\Console\Commands;

use App\Models\Factory\Api\UserLoanFactory;
use App\Models\Factory\Api\UserLoanLogFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserAuth;
use App\Models\Orm\UserLoan;
use App\Models\Orm\UserLoanLog;
use App\Models\Orm\UserLoanTask;
use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Factory\Api\UserLoanTaskFactory;
use App\Services\Core\Push\Yijiandai\YiJianDaiPushService;
use DB;

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
    protected $description = '一键贷推送结果获取';

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
        $start = 0;
        $count = 100;
        $error_num = 0;
        DB::beginTransaction();

        while(true){
            //获取任务列表
            $taskList = UserLoanTask::leftjoin(UserAuth::TABLE_NAME,'user_id','=',UserAuth::TABLE_NAME.'.id')
                        ->select(UserLoanTask::TABLE_NAME.'.*',UserAuth::TABLE_NAME.'.mobile')
                        ->where(UserLoanTask::TABLE_NAME.'.type_id',0)
                        ->where(UserLoanTask::TABLE_NAME.'.status',2)
                        ->skip($start)
                        ->take($count)
                        ->get()
                        ->toArray();

            if(empty($taskList)) break;

            //获取推送结果
            foreach($taskList as $k=>$v){
                if(strtotime("{$v['send_at']}+30 day") < strtotime(date('Y-m-d H:i:s'))){
                    $resTaskExpire = UserLoanTaskFactory::updateStatusById($v['id'],9); //task任务失效处理
                    $resOrderExpire = UserOrderFactory::updateOrderStatusByUserIdAndOrderNo($v['user_id'],$v['loan_order_no'],2); //根据失效task对应order_no修改订单
                    if($resTaskExpire && $resOrderExpire){
                        DB::commit();
                    }else{
                        DB::rollback();
                    }
                }else{
                    //获取订单信息
                    $data = UserOrderFactory::getOrderDetailByOrderNo($v['loan_order_no']);

                    if(empty($data)){
                        continue;
                    }

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
                        $taskRes = UserLoanTaskFactory::updateTaskResult($data);
                        //记录loan
                        $arr = [];
                        $resData = [];
                        foreach($res['data']['list'] as $res_key=>$res_val){
                            $arr['user_id'] = $data['user_id'];
                            $arr['platform_id'] = 1;
                            $arr['loan_order_no'] = $data['order_no'];
                            $arr['expire_day'] = $data['order_expired'];
                            $arr['loan_amount'] = $data['money'];
                            $arr['loan_peroid'] = $data['term'];
                            $arr['status'] = $res_val['status'];
                            $arr['create_at'] = date('Y-m-d H:i:s');
                            $resData[] = $arr;
                        }
                        $loanRes = UserLoan::insert($resData);
                        if($taskRes && $loanRes){
                            DB::commit();
                        }else{
                            $error_num++;
                            DB::rollback();
                        }
                    }else{
                        DB::commit();
                    }
                }
            }

            if(count($taskList) < $count) break;
            if($error_num >= $count) break;
        }






//        $taskList = UserLoanTask::leftjoin(UserAuth::TABLE_NAME,'user_id','=',UserAuth::TABLE_NAME.'.id')
//                    ->select(UserLoanTask::TABLE_NAME.'.*',UserAuth::TABLE_NAME.'.mobile')
//                    ->where(UserLoanTask::TABLE_NAME.'.type_id',0)
//                    ->where(UserLoanTask::TABLE_NAME.'.status',2)
//                    ->chunk(100,function($res_task){
//
//                    //数据处理
//                    foreach($res_task as $k=>$v){
//                        if(strtotime("{$v['create_at']}+30 day") < time()){
//                            UserLoanTaskFactory::updateStatusById($v['id'],9);
//                        }else{
//                            //获取订单信息
//                            $data = UserOrderFactory::getOrderDetailByOrderNo($v['loan_order_no']);
//
//                            //定义接口参数
//                            $sendParams['mobile'] = $v['mobile'];
//                            $res = YiJianDaiPushService::o()->getPull($sendParams);
//
//                            //组合参数
//                            $data['task_id'] = $v['id'];
//                            $data['request_data'] = json_encode($sendParams);
//                            $data['response_data'] = json_encode($res['data']['list']);
//                            $data['status'] = 3;
//                            $data['platform_id'] = 1;
//
//                            //记录loan_log
//                            UserLoanLogFactory::createUserLoanLog($data);
//
//                            //更新数据
//                            if($res['error_code'] == 0 && !empty($res['data']['list'])){
//                                //更新loan_task
//                                UserLoanTaskFactory::updateTaskResult($data);
//                                //记录loan
//                                foreach($res['data']['list'] as $res_key=>$res_val){
//                                    $data['res_status'] = $res_val['status'];
//                                    UserLoanFactory::createUserLoan($data);
//                                }
//                            }
//                        }
//                    }
//        });
    }
}
