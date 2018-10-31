<?php

namespace App\Http\Controllers\Admin\Order;

use App\Constants\OrderConstant;
use App\Http\Controllers\Controller;
use App\Models\Chain\Order\Loan\Refuse\DoRefuseOrderHandler;
use App\Models\Factory\Admin\Order\SaasOrderFactory;
use App\Models\Factory\Admin\Saas\SaasOrderInterestRateFactory;
use App\Models\Orm\SaasOrderSaas;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserReport;
use App\Strategies\OrderStrategy;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class LoanController extends Controller
{
    /**
     * 利率设置
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function interestRate(Request $request)
    {
        if ($request->isMethod('post')) {
            $res = $request->all();

            //检查订单状态
            $status = SaasOrderFactory::getOrderStatusById($res['id']);
            if ($status != OrderConstant::ORDER_STATUS_PASSED) {
                return redirect()->route('order.passed')->with('error', '该订单不是待放款状态');
            }

            $intRateInfo = [
                'loan_amounts' => $res['loan_amounts'],
                'normal_day_rate' => $res['normal_day_rate'],
                'service_rate' => $res['service_rate'] ?: 0,
                'lending_date' => $res['lending_date'],
                'repayment_date' => $res['repayment_date'],
                'overdue_daily_rate' => $res['overdue_daily_rate'],
            ];

            if ($info = SaasOrderInterestRateFactory::getBySaasOrderId($res['id'])) {
                SaasOrderInterestRateFactory::updateById($info->id, $intRateInfo);
            } else {
                SaasOrderInterestRateFactory::create(array_merge(['saas_order_id' => $res['id']], $intRateInfo));
            }

            return redirect()->route('admin.order.loan.interest_rate', ['id' => $res['id']])->with('success', '保存成功');
        }

        $id = $request->input('id');
        $borrowingBalance = OrderStrategy::getOrderInfoBySaasOrderSaasId($id)->saas_channel_detail['borrowing_balance'];
        $interestRateInfo = SaasOrderInterestRateFactory::getBySaasOrderId($id);

        return view('admin.order.loan.interest_rate', compact('id', 'borrowingBalance', 'interestRateInfo'));
    }

    /**
     * 批准放款
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function pass(Request $request)
    {
        if ($request->isMethod('post')) {
            $res = $request->all();
            //检查订单状态
            $status = SaasOrderFactory::getOrderStatusById($res['id']);
            if ($status != OrderConstant::ORDER_STATUS_PASSED) {
                return redirect()->route('admin.order.passed')->with('error', '该订单不是待放款状态');
            }

            $intRateInfo = [
                'loan_amounts' => $res['loan_amounts'],
                'normal_day_rate' => $res['normal_day_rate'],
                'service_rate' => $res['service_rate'] ?: 0,
                'lending_date' => $res['lending_date'],
                'repayment_date' => $res['repayment_date'],
                'overdue_daily_rate' => $res['overdue_daily_rate'],
            ];

            if ($info = SaasOrderInterestRateFactory::getBySaasOrderId($res['id'])) {
                SaasOrderInterestRateFactory::updateById($info->id, $intRateInfo);
            } else {
                SaasOrderInterestRateFactory::create(array_merge(['saas_order_id' => $res['id']], $intRateInfo));
            }

            //更新订单状态
            SaasOrderFactory::updateStatus($res['id'], OrderConstant::ORDER_STATUS_LOAN_PENDING);

            return redirect()->route('admin.order.passed')->with('success', '成功！');
        }

        $orderId = $request->input('order_id');
        $borrowingBalance = OrderStrategy::getOrderInfoById($orderId)->saas_channel_detail['borrowing_balance'];

        $saasOrderId = SaasOrderFactory::getIdByOrderIdAndPersonId($orderId, Auth::id());
        $interestRateInfo = SaasOrderInterestRateFactory::getBySaasOrderId($saasOrderId);
        $id = $saasOrderId;

        return view('admin.order.loan.interest_rate', compact('id', 'borrowingBalance', 'interestRateInfo'));
    }

    /**
     * 拒绝放款
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function refuse(Request $request)
    {
        if ($request->isMethod('post')) {
            $saasOrderId = SaasOrderFactory::getIdByOrderIdAndPersonId($request->input('order_id'), Auth::user()->id);
            //检查订单状态
            $status = SaasOrderFactory::getOrderStatusById($saasOrderId);
            if ($status != OrderConstant::ORDER_STATUS_PASSED) {
                return redirect()->route('admin.order.passed')->with('error', '该订单不是待放款状态');
            }

            $requests = [
                'order_id' => $request->input('order_id'),
                'reason' => $request->input('reason'),
                'saas_order_id' => $saasOrderId,
            ];

            $assignHandle = new DoRefuseOrderHandler($requests);
            $res = $assignHandle->handleRequest();

            if (isset($res['error'])) {
                return redirect()->route('admin.order.passed')->with('error', $res['error']);
            }

            return redirect()->route('admin.order.passed')->with('success', '成功！');
        }

        return view('admin.order.loan.refuse', ['id' => $request->input('order_id')]);
    }

    /**
     * 已拒绝放款
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refused(Request $request)
    {
        $start = $request->input('start') ?: Carbon::now()->subMonth();
        $end = $request->input('end', Carbon::now()->endOfDay());
        $ageLow = $request->input('age_low');
        $ageHigh = $request->input('age_high');
        $province = $request->input('province');
        $applyStatus = $request->input('apply_status'); //订单申请状态

        $orders = UserOrder::leftJoin(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->leftJoin(UserReport::TABLE_NAME, UserReport::TABLE_NAME . '.id', UserOrder::TABLE_NAME . '.user_report_id')
            ->select(
                UserOrder::TABLE_NAME . '.*',
                UserOrder::TABLE_NAME . '.id as order_id',
                SaasOrderSaas::TABLE_NAME.'.id as saas_order_id',
                SaasOrderSaas::TABLE_NAME.'.person_id',
                UserReport::TABLE_NAME . '.id as report_id',
                UserReport::TABLE_NAME . '.*',
                SaasOrderSaas::TABLE_NAME . '.assigned_at',
                SaasOrderSaas::TABLE_NAME . '.updated_at as check_time'
            )
            ->when($start, function ($query) use ($start, $end) {
                return $query->where(SaasOrderSaas::TABLE_NAME . '.assigned_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where(SaasOrderSaas::TABLE_NAME . '.assigned_at', '<=', $end);
            })->when($ageLow, function ($query) use ($ageLow) {
                return $query->where(UserReport::TABLE_NAME . '.age', '>=', $ageLow);
            })->when($ageHigh, function ($query) use ($ageHigh) {
                return $query->where(UserReport::TABLE_NAME . '.age', '<=', $ageHigh);
            })->when($province, function ($query) use ($province) {
                return $query->where(UserReport::TABLE_NAME . '.province', $province);
            })->when($applyStatus, function ($query) use ($applyStatus) {
                return $query->where(UserOrder::TABLE_NAME . '.apply_status', $applyStatus);
            });

        $orders = $orders->where(SaasOrderSaas::TABLE_NAME . '.person_id', Auth::user()->id)
            ->where(SaasOrderSaas::TABLE_NAME . '.status', OrderConstant::ORDER_STATUS_LOAN_REFUSED);

        $orders = $orders->orderBy(UserOrder::TABLE_NAME . '.id', 'desc')->paginate(10);

        return view('admin.order.loan.refused', compact('orders'));
    }
}
