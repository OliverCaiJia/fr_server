<?php

namespace App\Strategies;

use App\Constants\OrderConstant;
use App\Helpers\Formater\NumberFormater;
use App\Helpers\Logger\SLogger;
use App\Models\Factory\Admin\Order\OrderBasicInfoFactory;
use App\Models\Factory\Admin\Order\OrderFactory;
use App\Models\Factory\Admin\Users\UserReportFactory;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserReport;
use App\Models\User;
use DB;
use Exception;
use App\Helpers\Utils;
use Auth;
use Excel;

class OrderStrategy extends AppStrategy
{
    /**
     * 分批入库
     *
     * @param $reader
     */
    public static function import($reader)
    {
        $message = [
            'successCount' => 0,
            'errorCount' => 0,
            'errorData' => []
        ];
        $reader->chunk(200, function ($items) use ($message) {
            $items = $items->toArray();
            unset($items[0]);
            foreach ($items as $item) {
                if ($item[0]) {
                    DB::beginTransaction();
                    try {
                        $result = OrderStrategy::handlerItem($item);
                        if (!$result) {
                            $message['errorData'][] = '序号重复' . $item[0];
                            $message['errorCount'] += 1;
                            DB::rollBack();
                        } else {
                            $message['successCount'] += 1;
                        }

                        DB::commit();
                    } catch (Exception $exception) {
                        DB::rollBack();
                        SLogger::getStream()->error('导入订单信息存储-catch-序号' . $item['0']);
                        $message['errorData'][] = $item[0];
                        $message['errorCount'] += 1;

                        continue;
                    }
                }
            };

            session(['importMessage' => $message]);
        });
    }

    /**
     * 订单信息存储
     *
     * @param $item
     *
     * @return bool
     */
    public static function handlerItem($item)
    {
        $name = $item['1'];
        $idCard = $item['2'];
        $mobile = $item['3'];
        $source = $item['8'] ?: '外部导入';

        $repeated = self::checkRepeated($name, $idCard, $mobile, $source);
        if ($repeated) {
            return false;
        }

        $user = User::create([
            'name' => $name,
            'id_card' => $idCard,
            'mobile' => $mobile,
            'account_name' => $mobile,
            'last_login_ip' => Utils::ipAddress(),
            'version' => 3,
            'is_import' => 1,
            'update_ip' => Utils::ipAddress()
        ]);

        $userReport = UserReport::create([
            'user_basic' => array_merge(
                UserStrategy::getUserInfoByIdCard($item['2']),
                [
                    'mobile' => $item['3'],
                    'name' => $name,
                    'id_card' => $idCard,
                    'update_time' => date('Y-m-d H:i:s', time())
                ],
                UserStrategy::getPhoneInfoByPhone($item['3'])
            ),
            'user_id' => $user->id,
            'name' => $name,
            'id_card' => $idCard,
            'mobile' => $mobile,
            'location' => UserStrategy::getLocationByIdCard($item['2']),
            'address' => ''
        ]);

        UserOrder::create([
            'person_id' => Auth::user()->id,
            'operator_id' => 0,
            'user_id' => $user->id,
            'user_report_id' => $userReport->id,
            'amount' => $item['4'],
            'cycle' => $item['5'],
            'repayment_method' => OrderStrategy::getRepaymentMethodByText($item['6']),
            'created_at' => $item['7'],
            'source' => $source,
            'orderid' => UserOrderStrategy::createOrderId(),
            'channel_id' => 0,
            'created_ip' => Utils::ipAddress(),
        ]);

        return true;
    }

    /**
     * 获取还款方式通过文本
     *
     * @param $method
     *
     * @return mixed
     */
    public static function getRepaymentMethodByText($method)
    {
        return array_flip(OrderConstant::ORDER_PAYMENT_METHOD)[$method];
    }

    /**
     * 检查重复数据
     *
     * @param $name
     * @param $idCard
     * @param $mobile
     * @param $source
     *
     * @return bool
     */
    public static function checkRepeated($name, $idCard, $mobile, $source)
    {
        $report = UserReportFactory::getIdByWhere([
            ['name', $name],
            ['id_card', $idCard],
            ['mobile', $mobile]
        ]);

        if (!$report) {
            return false;
        }

        $order = OrderFactory::getSourceByReportId($report->id);

        if (!$order) {
            return false;
        }

        if ($order->source == $source) {
            return true;
        }
    }

    public static function download($orders)
    {
        $data = [];
        foreach ($orders as $key => $order) {
            $data[$key] = [
                'ordinal' => $key + 1,
                'mobile' => $order['user_report']['mobile'],
                'name' => $order['user_report']['name'],
                'id_card' => '\'' . $order['user_report']['id_card'],
                'age' => $order['user_report']['age'],
                'province' => $order['user_report']['province'],
                'status' => OrderConstant::ORDER_STATUS_MAP[$order['status']],
                'channel' => UserOrderStrategy::getChannelText($order),
                'price' => NumberFormater::roundedAmount($order['order_price']) . '元',
                'assigned_at' => $order['assigned_at'],
            ];
        }
        $range = 'A1:J' . (count($orders) + 1);
        Excel::create('订单导出', function ($excel) use ($data, $range) {
            $excel->sheet('Sheet1', function ($sheet) use ($data, $range) {
                $sheet->prependRow(['序号', '手机号', '姓名', '证件号', '年龄', '户籍省份', '状态', '渠道', '单价', '申请时间']);
                $sheet->setWidth(['A' => 20, 'B' => 20, 'C' => 20, 'D' => 20, 'E' => 20, 'F' => 20, 'G' => '20', 'H' => 20, 'I' => 20, 'J' => 20]);
                $sheet->rows($data);
                $sheet->cells($range, function ($cells) {
                    $cells->setAlignment('left');
                });
            });
        })->download('xls');
    }

    public static function getOrderIdByUserInfo($userName, $userIdCard, $userMobile)
    {
        $userParams = [
            'select' => ['user_id'],
        ];

        if ($userName) {
            $userParams['where'][] = ['name', '=', $userName];
        }

        if ($userIdCard) {
            $userParams['where'][] = ['id_card', '=', $userIdCard];
        }

        if ($userMobile) {
            $userParams['where'][] = ['mobile', '=', $userMobile];
        }

        $userIds = OrderBasicInfoFactory::getAll($userParams);
        $userIds = array_unique(array_column($userIds, 'user_id'));

        $orderParams = [
            'select' => ['id'],
            'where_in' => [
                'user_id' => $userIds
            ]
        ];

        $orderids = OrderFactory::getAll($orderParams);
        $orderids = array_column($orderids, 'id');

        return $orderids;
    }
}
