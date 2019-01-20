<?php

namespace App\Console\Commands;

use App\Console\Commands\AppCommand;
use App\Models\Orm\UserLoanTask;

class LoanCommand extends AppCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'LoanCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an MailCommand';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->comment(PHP_EOL . '==' . PHP_EOL);

        //Log::info('开始程序!', ['code' => 3333]);
        try {
//            'user_id', '=', $datas['user_id']
//            UserLoanTask::select()->where(['status' => 0, 'from' => SpreadConstant::SPREAD_FORM])
            UserLoanTask::select()
                ->where(['status', '=', 0])
                ->orWhere(['status', '=', 2])
                ->chunk(100, function ($messages) {
                    //SLogger::getStream()->info('message',['message'=>$messages]);
                    $nowTime = date('Y-m-d H:i:s', time());
                    foreach ($messages as $message) {
                        //SLogger::getStream()->info('时间未到',['message'=>$messages]);
                        $res = '';
                        //根据发送时间进行筛选
                        if ($message['send_at'] < $nowTime) {
                            //根据typeId获取typeNid
                            $typeInfo = UserSpreadFactory::fetchSpreadTypeNid($message['type_id']);
                            if (!empty($typeInfo)) {
                                //延迟推送信息
                                $speadInfo = UserSpreadFactory::fetchUserSpreadByMobile($message['mobile']);
                                //SLogger::getStream()->info('开始推送',['data'=>$speadInfo]);
                                $speadInfo['spread_log_id'] = $message['spread_log_id'];
                                $speadInfo['batch_id'] = $message['id'];
                                $speadInfo['type_id'] = $message['type_id'];
                                $spreadNid = $typeInfo ? explode('_', $typeInfo['type_nid']) : '';
                                $speadInfo['spread_nid'] = $spreadNid ? $spreadNid[1] : '';
                                $speadInfo['type_nid'] = $typeInfo['type_nid'];
                                $speadInfo['choice_status'] = $typeInfo['choice_status'];
                                $speadInfo['limit'] = $typeInfo['limit'];
                                $speadInfo['total'] = $typeInfo['total'];
                                event(new UserSpreadBatchEvent($speadInfo));
                            }
                        }
                    }
                });
        } catch (\Exception $ex) {
            \Log::error($ex);
        }

    }
}
