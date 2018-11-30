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
        $orderTypeList = UserOrder::join('user_order_type','user_order.order_type','=','user_order_type.id')
            ->select('user_order.status','user_order.create_at','user_order_type.type_nid','user_order.user_id','user_order.order_no')
            ->where('user_order.status','=',0)
            ->where('user_order_type.status','=',1)
            ->get()
            ->toArray();
        if(empty($orderTypeList)){
            return;
        }

        $data = [
            'status' => 2,
            'update_ip' => Utils::ipAddress(),
        ];

        foreach($orderTypeList as $order_key => $order_val){
            $pay_create_at = strtotime("{$order_val['create_at']}+7 day");
            if($pay_create_at <= strtotime(date('Y-m-d H:i:s')) && in_array($order_val['type_nid'],$pay_order)){
                $data['update_at'] = date('Y-m-d H:i:s');
                UserOrderFactory::updateOrderByUserIdAndOrderNo($order_val['user_id'],$order_val['order_no'],$data);
            }
        }
    }
}
