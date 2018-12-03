<?php

namespace App\Console\Commands;

use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserOrder;
use Illuminate\Console\Command;
use App\Helpers\Utils;

class OrderStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:orderstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单过期状态跑批';

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
     * 订单状态修改 未处理订单 付费订单7天过期
     */
    public function handle()
    {
        $pay_order = config("order.pay_order"); //付费订单
        $start = 0;
        $count = 100;

        while(true) {
            $orderTypeList = UserOrder::join('user_order_type','user_order.order_type','=','user_order_type.id')
                ->select('user_order.status','user_order.update_at','user_order_type.type_nid','user_order.user_id','user_order.order_no')
                ->where('user_order.status','=',0)
                ->where('user_order_type.status','=',1)
                ->skip($start)->take($count)
                ->get()
                ->toArray();

            foreach($orderTypeList as $order_key => $order_val){
                $pay_update_at = strtotime("{$order_val['update_at']}+7 day");
                if($pay_update_at <= strtotime(date('Y-m-d H:i:s')) && in_array($order_val['type_nid'],$pay_order)){
                    $data = [
                        'status' => 2,
                        'update_at' => date('Y-m-d H:i:s'),
                        'update_ip' => Utils::ipAddress(),
                    ];
                    UserOrderFactory::updateOrderByUserIdAndOrderNo($order_val['user_id'],$order_val['order_no'],$data);
                }
            }

            if(count($orderTypeList) < $count) break;
        }
    }
}
