<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Factory\Api\UserLoanTaskFactory;
use App\Models\Orm\UserLoanTask;

class TaskNotActiveHandle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:tasknotactivehandle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'task表未激活状态跑批处理';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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

        while(true) {
            $res_task = UserLoanTask::where('status', '=', 0)
                ->where(DB::raw('(sgd_user_loan_task.create_at + INTERVAL 1 hour)'),'<=',DB::raw("DATE_FORMAT(now(),'%Y-%m-%d %H-%i-%s')"))
                ->skip($start)
                ->take($count)
                ->get()
                ->toArray();

            if (empty($res_task)) break;

            foreach ($res_task as $task_key => $task_val){
                $task_data = [
                    'status' => 1,
                    'update_at' => date('Y-m-d H:i:s')
                ];
                $task_up = UserLoanTaskFactory::updateDataById($task_val['id'],$task_data);
                if(!$task_up){
                    $error_num++;
                }
            }

            if(count($res_task) < $count) break;
            if($error_num >= $count) break;
        }
    }
}
