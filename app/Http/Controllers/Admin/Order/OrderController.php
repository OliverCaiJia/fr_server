<?php

namespace App\Http\Controllers\Admin\Order;

use App\Constants\OrderConstant;
use App\Events\OperationLogEvent;
use App\Http\Controllers\Controller;
use App\Models\Chain\Order\Assign\DoAssignHandler;
use App\Models\Chain\Order\Pass\DoPassOrderHandler;
use App\Models\Chain\Order\Refuse\DoRefuseOrderHandler;
use App\Models\Factory\Admin\Order\OrderFactory;
use App\Models\Factory\Admin\Order\SaasOrderFactory;
use App\Models\Factory\Admin\Saas\SaasOrderInterestRateFactory;
use App\Models\Factory\Admin\Saas\SaasOrderRepaymentInfoFactory;
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use App\Models\Orm\SaasOrderInterestRate;
use App\Models\Orm\SaasOrderRepaymentInfo;
use App\Models\Orm\SaasOrderSaas;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderBasicInfo;
use App\Models\Orm\UserReport;
use App\Strategies\CertifyTaobaoStrategy;
use App\Strategies\OrderStrategy;
use App\Strategies\AdminPersonStrategy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Excel;
use Exception;

class OrderController extends Controller
{
    /**
     * 已拒绝订单列表
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refused(Request $request)
    {
        $start = $request->input('start') ?: Carbon::now()->subMonth();
        $end = $request->input('end', Carbon::now()->endOfDay());
        $ageLow = $request->input('age_low'); //年龄上限
        $ageHigh = $request->input('age_high'); //年龄下限
        $province = $request->input('province'); //户籍省份
        $applyStatus = $request->input('apply_status'); //订单申请状态

        $query = UserOrder::leftJoin(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
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
            );

        $orders = $query->when($start, function ($query) use ($start, $end) {
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
            ->where(SaasOrderSaas::TABLE_NAME . '.status', OrderConstant::ORDER_STATUS_REFUSED);

        $orders = $orders->orderBy(SaasOrderSaas::TABLE_NAME . '.assigned_at', 'desc')->paginate(10);

        return view('admin.order.refused', compact('orders'));
    }

    /**
     * 已通过订单列表
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function passed(Request $request)
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
            ->where(SaasOrderSaas::TABLE_NAME . '.status', OrderConstant::ORDER_STATUS_PASSED);

        $orders = $orders->orderBy(UserOrder::TABLE_NAME . '.id', 'desc')->paginate(10);

        return view('admin.order.passed', compact('orders'));
    }

    /**
     * 待处理订单列表
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pending(Request $request)
    {
        $start = $request->input('start') ?: Carbon::now()->subMonth();
        $end = $request->input('end', Carbon::now()->endOfDay());
        $ageLow = $request->input('age_low');
        $ageHigh = $request->input('age_high');
        $province = $request->input('province');
        $applyStatus = $request->input('apply_status');

        $orders = UserOrder::join(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->join(UserReport::TABLE_NAME, UserReport::TABLE_NAME . '.id', UserOrder::TABLE_NAME . '.user_report_id')
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
                ->where(SaasOrderSaas::TABLE_NAME . '.status', OrderConstant::ORDER_STATUS_PENDING)
                ->where(SaasOrderSaas::TABLE_NAME . '.assigned_at', '<=', Carbon::now())
        ->orderBy(UserOrder::TABLE_NAME . '.id', 'desc')->paginate(10);

        $person = SaasPersonFactory::getAllPersonByPersonId(Auth::user()->id);

        return view('admin.order.pending', compact('orders', 'person'));
    }

    /**
     * 分配订单
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws Exception
     */
    public function assign(Request $request)
    {
        if ($request->isMethod('post')) {
            $requests = [
                'order_id' => $request->input('id'),
                'person_id' => $request->input('person_id'),
                'saas_order_id' => SaasOrderFactory::getIdByOrderIdAndPersonId(
                    $request->input('id'),
                    Auth::user()->id
                ),
            ];
            $assignHandle = new DoAssignHandler($requests);
            $res = $assignHandle->handleRequest();

            if (isset($res['error'])) {
                return redirect()->route('admin.order.pending')->with('error', $res['error']);
            }

            return redirect()->route('admin.order.pending')->with('success', '成功！');
        }

        $allPerson = [];
        $orderInfo = OrderFactory::getOrderInfoById($request->input('id'));
        if ($orderInfo) {
            $allPerson = SaasPersonFactory::getAllPersonByPersonId(Auth::user()->id);
        }

        return view('admin.order.assign', [
            'id' => $request->input('id'),
            'items' => $allPerson
        ]);
    }

    /**
     * 批量分配订单给手下人员
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function batchAssign(Request $request)
    {
        if ($request->isMethod('post')) {
            $orders = $request->input('order_id');
            if (empty($orders)) {
                return redirect()->route('admin.order.pending')->with('error', '分配失败，请先选择订单！');
            }
            $personId = $request->input('person_id');
            $orders = explode(',', $orders);
            foreach ($orders as $orderId) {
                $requests = [
                    'order_id' => $orderId,
                    'person_id' => $personId,
                    'saas_order_id' => SaasOrderFactory::getIdByOrderIdAndPersonId(
                        $orderId,
                        Auth::user()->id
                    ),
                ];
                $assignHandle = new DoAssignHandler($requests);
                $res = $assignHandle->handleRequest();
                if (isset($res['error'])) {
                    return redirect()->route('admin.order.pending')->with('error', $res['error']);
                }
            }
            return redirect()->route('admin.order.pending')->with('success', '成功！');
        }
        return redirect()->route('admin.order.pending')->with('error', 'Invalid Request!');
    }

    /**
     * 订单审核通过
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function passOrder(Request $request)
    {
        $requests = [
            'order_id' => $request->input('order_id'),
            'saas_order_id' => SaasOrderFactory::getIdByOrderIdAndPersonId(
                $request->input('order_id'),
                Auth::user()->id
            ),
        ];
        $assignHandle = new DoPassOrderHandler($requests);
        $res = $assignHandle->handleRequest();

        if (isset($res['error'])) {
            return redirect()->route('admin.order.pending')->with('error', $res['error']);
        }

        return redirect()->route('admin.order.pending')->with('success', '成功！');
    }

    /**
     * 订单审核拒绝
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws Exception
     */
    public function refuseOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $requests = [
                'order_id' => $request->input('order_id'),
                'reason' => $request->input('reason'),
                'saas_order_id' => SaasOrderFactory::getIdByOrderIdAndPersonId(
                    $request->input('order_id'),
                    Auth::user()->id
                ),
            ];

            $assignHandle = new DoRefuseOrderHandler($requests);
            $res = $assignHandle->handleRequest();

            if (isset($res['error'])) {
                return redirect()->route('admin.order.pending')->with('error', $res['error']);
            }

            return redirect()->route('admin.order.pending')->with('success', '成功！');
        }

        return view('admin.order.refuseView', ['id' => $request->input('order_id')]);
    }

    /**
     * 订单记录
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $start = $request->input('start') ?: Carbon::now()->subMonth();
        $end = $request->input('end', Carbon::now()->endOfDay());
        $status = $request->input('status');
        $applyStatus = $request->input('apply_status');
        $userName = $request->input('user_name');
        $userIdCard = $request->input('user_id_card');
        $userMobile = $request->input('user_mobile');
        $province = $request->input('province');
        $orderIds = 0;
        $userFilter = false;

        if ($userName || $userIdCard || $userMobile) {
            $userFilter = true;
            $orderIds = OrderStrategy::getOrderIdByUserInfo($userName, $userIdCard, $userMobile);
        }

        $query = UserOrder::leftJoin(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->leftJoin(UserReport::TABLE_NAME, UserReport::TABLE_NAME . '.id', UserOrder::TABLE_NAME . '.user_report_id')
            ->leftJoin(UserOrderBasicInfo::TABLE_NAME, UserOrderBasicInfo::TABLE_NAME.'.id', UserReport::TABLE_NAME.'.basic_info_id')
            ->select(
                SaasOrderSaas::TABLE_NAME.'.id as saas_order_id',
                SaasOrderSaas::TABLE_NAME . '.status as saas_order_status',
                'user_report_id',
                UserOrder::TABLE_NAME . '.id as order_id',
                SaasOrderSaas::TABLE_NAME . '.created_at',
                SaasOrderSaas::TABLE_NAME . '.assigned_at',
                'saas_channel_detail',
                'source',
                SaasOrderSaas::TABLE_NAME . '.order_price',
                UserReport::TABLE_NAME . '.age',
                UserReport::TABLE_NAME . '.province',
                UserOrder::TABLE_NAME.'.apply_status',
                UserReport::TABLE_NAME.'.*',
                UserOrderBasicInfo::TABLE_NAME.'.monthly_income'
            );

        $query->selectRaw(env('DB_PREFIX') . SaasOrderSaas::TABLE_NAME . '.order_price as price');

        $query = $query->when($start, function ($query) use ($start, $end) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.assigned_at', '>=', $start);
        })->when($end, function ($query) use ($end) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.assigned_at', '<=', $end);
        })->when($status != 6 ? $status : $status = 5, function ($query) use ($status) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.status', $status);
        })->when($status != 6 ? '': date('Y-m-d'), function ($query) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.repayment_date', '<', date('Y-m-d'));
        })->when($province, function ($query) use ($province) {
            return $query->where(UserReport::TABLE_NAME . '.province', $province);
        })->when($userFilter, function ($query) use ($orderIds) {
            return $query->whereIn(SaasOrderSaas::TABLE_NAME . '.order_id', $orderIds);
        })->when($applyStatus, function ($query) use ($applyStatus) {
            return $query->where(UserOrder::TABLE_NAME . '.apply_status', '=', $applyStatus);
        });

        $personIds = SaasPersonStrategy::getPersonIdsByUserId(Auth::user()->id);
        $query = $query->whereIn(SaasOrderSaas::TABLE_NAME . '.person_id', $personIds);

        if ($request->input('export')) {
            $orders = $query->select(SaasOrderSaas::TABLE_NAME . '.status', 'user_report_id', UserOrder::TABLE_NAME . '.id', SaasOrderSaas::TABLE_NAME . '.created_at', SaasOrderSaas::TABLE_NAME . '.assigned_at', 'saas_channel_detail', 'source', SaasOrderSaas::TABLE_NAME . '.order_price')
                ->with('userReport')
                ->orderBy(SaasOrderSaas::TABLE_NAME.'.assigned_at', 'desc')
                ->limit(1000)
                ->get()
                ->toArray();
            event(new OperationLogEvent(102, json_encode(array_column($orders, 'id'))));
            return OrderStrategy::download($orders);
        }

        $totalPrice = $query->sum(SaasOrderSaas::TABLE_NAME . '.order_price');
        $orders = $query->orderBy(SaasOrderSaas::TABLE_NAME.'.assigned_at', 'desc')->paginate(10);

        return view('admin.order.index', compact('orders', 'totalPrice'));
    }

    /**
     * 订单详情
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $id)
    {
        $order = OrderFactory::getDetail($id);
        $personIds = SaasPersonStrategy::getPersonIdsByUserId(Auth::user()->id);
        $status = SaasOrderFactory::getStatusByOrderIdAndPersonIds($id, $personIds);
        $taobaoId = $order->userReport->taobao_id;
        $taobaoInfo = CertifyTaobaoStrategy::getAndDealTaobaoInfoById($taobaoId);

        $type = $request->input('type', 'pending');

        return view('admin.order.detail', compact('order', 'status', 'taobaoInfo', 'type'));
    }

    /**
     * 导入订单
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function import(Request $request)
    {
        if (!$request->hasFile('file')) {
            return redirect()->back()->withErrors(['file' => '文件不能为空']);
        }

        //检查文件扩展名
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, ['xls', 'xlsx'])) {
            return redirect()->back()->withErrors(['file' => '文件只支持 xls, xlsx 类型']);
        }
        //保存文件
        $storage_path = storage_path('app/public/excel');
        if (!file_exists($storage_path)) {
            mkdir($storage_path, 0777, true);
        }
        $filename = md5(ceil(microtime(true) * 1000)) . '.' . $extension;
        if ($file->move($storage_path, $filename) == false) {
            return redirect()->back()->withErrors(['file' => '文件上传失败']);
        }

        try {
            $reader = Excel::load($storage_path . '/' . $filename);
            OrderStrategy::import($reader);
            $message = session()->pull('importMessage');
            session()->remove('importMessage');

            $successMessage = '上传成功: ' . $message['successCount'] . '条.';
            $errorMessage = $message['errorData']
                ? '上传失败: ' . implode(', ', $message['errorData']) . ', 共' . $message['errorCount'] . '条.'
                : '';

            return redirect()->route('admin.order.pending')
                ->with('success', '上传完成, ' . $successMessage . $errorMessage);
        } catch (Exception $exception) {
            return redirect()->back()->withErrors(['file' => '上传失败']);
        }
    }

    /**
     * 订单上传模板下载
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function template()
    {
        event(new OperationLogEvent(101));
        return response()->download(public_path('order/订单导入模板.xlsx'));
    }

    /**
     * 待还款
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function repaying(Request $request)
    {
        $repaymentDateStart = $request->input('repayment_date_start') ?: date('Y-m-d');
        $repaymentDateEnd = $request->input('repayment_date_end') ?: '';
        $lendingDateStart = $request->input('lending_date_start') ?: '';
        $lendingDateEnd = $request->input('lending_date_end') ?: '';
        $userName = $request->input('user_name');
        $userMobile = $request->input('user_mobile');
        $orderIds = 0;
        $userFilter = false;

        if ($userName || $userMobile) {
            $userFilter = true;
            $orderIds = OrderStrategy::getOrderIdByUserInfo($userName, '', $userMobile);
        }

        $query = UserOrder::leftJoin(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->leftJoin(SaasOrderInterestRate::TABLE_NAME, SaasOrderInterestRate::TABLE_NAME . '.saas_order_id', SaasOrderSaas::TABLE_NAME . '.id')
            ->select(
                UserOrder::TABLE_NAME .'.user_id',
                UserOrder::TABLE_NAME .'.user_report_id',
                SaasOrderInterestRate::TABLE_NAME.'.loan_amounts',
                SaasOrderInterestRate::TABLE_NAME.'.lending_date',
                SaasOrderInterestRate::TABLE_NAME.'.repayment_date',
                SaasOrderInterestRate::TABLE_NAME.'.normal_day_rate',
                SaasOrderInterestRate::TABLE_NAME.'.service_rate',
                SaasOrderSaas::TABLE_NAME.'.id as saas_order_id'
            )
            ->where(SaasOrderSaas::TABLE_NAME . '.person_id', '=', Auth::user()->id);

        $query = $query->when($repaymentDateStart, function ($query) use ($repaymentDateStart) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.repayment_date', '>=', $repaymentDateStart);
        })->when($repaymentDateEnd, function ($query) use ($repaymentDateEnd) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.repayment_date', '<=', $repaymentDateEnd);
        })->when($lendingDateStart, function ($query) use ($lendingDateStart) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.lending_date', '>=', $lendingDateStart);
        })->when($lendingDateEnd, function ($query) use ($lendingDateEnd) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.lending_date', '<=', $lendingDateEnd);
        })->when(true, function ($query) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.status', OrderConstant::ORDER_STATUS_LOAN_PENDING);
        })->when($userFilter, function ($query) use ($orderIds) {
            return $query->whereIn(SaasOrderSaas::TABLE_NAME . '.order_id', $orderIds);
        });

        $orders = $query->orderBy(SaasOrderInterestRate::TABLE_NAME.'.lending_date', 'desc')
            ->orderBy(SaasOrderSaas::TABLE_NAME.'.order_id', 'desc')
            ->paginate(10);

        return view('admin.order.repaymanage.repaying', [
            'orders' => $orders
        ]);
    }

    /**
     * 逾期未还款订单
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overdueRepaying(Request $request)
    {
        $overdueDayMin = $request->input('overdue_day_min') ?: 1;
        $overdueDayMax = $request->input('overdue_day_max') ?: '';
        $repaymentDateStart = $request->input('repayment_date_start') ?: '';
        $repaymentDateEnd = $request->input('repayment_date_end') ?: date("Y-m-d", strtotime("-1 day"));

        if ($overdueDayMin && $repaymentDateEnd) {
            $overdueDateMin = date("Y-m-d", strtotime("-". $overdueDayMin ." day"));
            if (strtotime($overdueDateMin) < strtotime($repaymentDateEnd)) {
                $repaymentDateEnd = $overdueDateMin;
            }
        }
        if ($overdueDayMax && $repaymentDateStart) {
            $overdueDateMax = date("Y-m-d", strtotime("-". $overdueDayMax ." day"));
            if (strtotime($overdueDateMax) > strtotime($repaymentDateStart)) {
                $repaymentDateStart = $overdueDateMax;
            }
        } elseif ($overdueDayMax && empty($repaymentDateStart)) {
            $repaymentDateStart = date("Y-m-d", strtotime("-". $overdueDayMax ." day"));
        }

        $lendingDateStart = $request->input('lending_date_start') ?: '';
        $lendingDateEnd = $request->input('lending_date_end') ?: '';
        $userName = $request->input('user_name');
        $userMobile = $request->input('user_mobile');
        $orderIds = 0;
        $userFilter = false;

        if ($userName || $userMobile) {
            $userFilter = true;
            $orderIds = OrderStrategy::getOrderIdByUserInfo($userName, '', $userMobile);
        }

        $query = UserOrder::leftJoin(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->leftJoin(SaasOrderInterestRate::TABLE_NAME, SaasOrderInterestRate::TABLE_NAME . '.saas_order_id', SaasOrderSaas::TABLE_NAME . '.id')
            ->select(
                UserOrder::TABLE_NAME .'.user_id',
                UserOrder::TABLE_NAME .'.user_report_id',
                SaasOrderInterestRate::TABLE_NAME.'.loan_amounts',
                SaasOrderInterestRate::TABLE_NAME.'.lending_date',
                SaasOrderInterestRate::TABLE_NAME.'.repayment_date',
                SaasOrderInterestRate::TABLE_NAME.'.normal_day_rate',
                SaasOrderInterestRate::TABLE_NAME.'.service_rate',
                SaasOrderInterestRate::TABLE_NAME.'.overdue_daily_rate',
                SaasOrderSaas::TABLE_NAME.'.id as saas_order_id'
            )
            ->where(SaasOrderSaas::TABLE_NAME . '.person_id', '=', Auth::user()->id);

        $query = $query->when($repaymentDateStart, function ($query) use ($repaymentDateStart) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.repayment_date', '>=', $repaymentDateStart);
        })->when($repaymentDateEnd, function ($query) use ($repaymentDateEnd) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.repayment_date', '<=', $repaymentDateEnd);
        })->when($lendingDateStart, function ($query) use ($lendingDateStart) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.lending_date', '>=', $lendingDateStart);
        })->when($lendingDateEnd, function ($query) use ($lendingDateEnd) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.lending_date', '<=', $lendingDateEnd);
        })->when(true, function ($query) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.status', OrderConstant::ORDER_STATUS_LOAN_PENDING);
        })->when($userFilter, function ($query) use ($orderIds) {
            return $query->whereIn(SaasOrderSaas::TABLE_NAME . '.order_id', $orderIds);
        });

        $orders = $query->orderBy(SaasOrderInterestRate::TABLE_NAME.'.lending_date', 'desc')
            ->orderBy(SaasOrderSaas::TABLE_NAME.'.order_id', 'desc')
            ->paginate(10);

        return view('admin.order.repaymanage.overdueRepaying', [
            'orders' => $orders
        ]);
    }

    /**
     * 已还款
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function repayed(Request $request)
    {
        $overdueDayMin = $request->input('overdue_day_min');
        $overdueDayMax = $request->input('overdue_day_max');
        $repaymentDateStart = $request->input('repayment_date_start');
        $repaymentDateEnd = $request->input('repayment_date_end');
        $lendingDateStart = $request->input('lending_date_start') ?: '';
        $lendingDateEnd = $request->input('lending_date_end') ?: '';
        $userName = $request->input('user_name');
        $userMobile = $request->input('user_mobile');
        $repaymentMethod = $request->input('repayment_method');
        $type = $request->input('type');
        $realRepaymentDateStart = $request->input('real_repayment_date_start');
        $realRepaymentDateEnd = $request->input('real_repayment_date_end');
        $orderIds = 0;
        $userFilter = false;

        if ($userName || $userMobile) {
            $userFilter = true;
            $orderIds = OrderStrategy::getOrderIdByUserInfo($userName, '', $userMobile);
        }

        $query = UserOrder::leftJoin(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->leftJoin(SaasOrderInterestRate::TABLE_NAME, SaasOrderInterestRate::TABLE_NAME . '.saas_order_id', SaasOrderSaas::TABLE_NAME . '.id')
            ->leftJoin(SaasOrderRepaymentInfo::TABLE_NAME, SaasOrderRepaymentInfo::TABLE_NAME . '.saas_order_id', SaasOrderSaas::TABLE_NAME . '.id')
            ->select(
                UserOrder::TABLE_NAME .'.user_id',
                UserOrder::TABLE_NAME .'.user_report_id',
                SaasOrderInterestRate::TABLE_NAME.'.loan_amounts',
                SaasOrderInterestRate::TABLE_NAME.'.lending_date',
                SaasOrderInterestRate::TABLE_NAME.'.repayment_date',
                SaasOrderInterestRate::TABLE_NAME.'.normal_day_rate',
                SaasOrderInterestRate::TABLE_NAME.'.service_rate',
                SaasOrderInterestRate::TABLE_NAME.'.overdue_daily_rate',
                SaasOrderSaas::TABLE_NAME.'.id as saas_order_id',
                SaasOrderRepaymentInfo::TABLE_NAME.'.overdue_days',
                SaasOrderRepaymentInfo::TABLE_NAME.'.type',
                SaasOrderRepaymentInfo::TABLE_NAME.'.repayment_date as real_repayment_date',
                SaasOrderRepaymentInfo::TABLE_NAME.'.repayment_amount',
                SaasOrderRepaymentInfo::TABLE_NAME.'.repayment_method'
            )
            ->where(SaasOrderSaas::TABLE_NAME . '.person_id', '=', Auth::user()->id);

        $query = $query->when($repaymentMethod, function ($query) use ($repaymentMethod) {
            return $query->where(SaasOrderRepaymentInfo::TABLE_NAME . '.repayment_method', '=', $repaymentMethod);
        })->when($type, function ($query) use ($type) {
            return $query->where(SaasOrderRepaymentInfo::TABLE_NAME . '.type', '=', $type);
        })->when($realRepaymentDateStart, function ($query) use ($realRepaymentDateStart) {
            return $query->where(SaasOrderRepaymentInfo::TABLE_NAME . '.repayment_date', '>=', $realRepaymentDateStart);
        })->when($realRepaymentDateEnd, function ($query) use ($realRepaymentDateEnd) {
            return $query->where(SaasOrderRepaymentInfo::TABLE_NAME . '.repayment_date', '>=', $realRepaymentDateEnd);
        })->when($overdueDayMin, function ($query) use ($overdueDayMin) {
            return $query->where(SaasOrderRepaymentInfo::TABLE_NAME . '.overdue_days', '>=', $overdueDayMin);
        })->when($overdueDayMax, function ($query) use ($overdueDayMax) {
            return $query->where(SaasOrderRepaymentInfo::TABLE_NAME . '.overdue_days', '<=', $overdueDayMax);
        })->when($repaymentDateStart, function ($query) use ($repaymentDateStart) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.repayment_date', '>=', $repaymentDateStart);
        })->when($repaymentDateEnd, function ($query) use ($repaymentDateEnd) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.repayment_date', '<=', $repaymentDateEnd);
        })->when($lendingDateStart, function ($query) use ($lendingDateStart) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.lending_date', '>=', $lendingDateStart);
        })->when($lendingDateEnd, function ($query) use ($lendingDateEnd) {
            return $query->where(SaasOrderInterestRate::TABLE_NAME . '.lending_date', '<=', $lendingDateEnd);
        })->when(true, function ($query) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.status', OrderConstant::ORDER_STATUS_LOAN_FINISHED);
        })->when($userFilter, function ($query) use ($orderIds) {
            return $query->whereIn(SaasOrderSaas::TABLE_NAME . '.order_id', $orderIds);
        });

        $orders = $query->orderBy(SaasOrderInterestRate::TABLE_NAME.'.lending_date', 'desc')
            ->orderBy(SaasOrderSaas::TABLE_NAME.'.order_id', 'desc')
            ->paginate(10);

        return view('admin.order.repaymanage.repayed', [
            'orders' => $orders
        ]);
    }

    /**
     * 还款标记
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function repayDetail(Request $request)
    {
        $saasOrderId = $request->input('saas_order_id');

        if ($request->isMethod('post')) {
            $params = [
                'where' => [
                    'saas_order_id' => $saasOrderId
                ]
            ];
            $getInfo = SaasOrderRepaymentInfoFactory::getOne($params);

            if (empty($getInfo)) {
                $insertData = $request->except('_token');
                SaasOrderRepaymentInfoFactory::insertGetId($insertData);
                SaasOrderFactory::updateStatus($saasOrderId, OrderConstant::ORDER_STATUS_LOAN_FINISHED);
            }

            return redirect()->route('admin.order.repaymanage.repaying')->with('success', '成功！');
        }

        $saasOrderInfo = SaasOrderInterestRateFactory::getBySaasOrderId($saasOrderId);

        return view('admin.order.repaymanage.repayDetail', [
            'saasOrderInfo' => $saasOrderInfo
        ]);
    }

    /**
     * 逾期还款标记
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function overdueRepayDetail(Request $request)
    {
        $saasOrderId = $request->input('saas_order_id');

        if ($request->isMethod('post')) {
            $params = [
                'where' => [
                    'saas_order_id' => $saasOrderId
                ]
            ];
            $getInfo = SaasOrderRepaymentInfoFactory::getOne($params);

            if (empty($getInfo)) {
                $insertData = $request->except('_token');
                SaasOrderRepaymentInfoFactory::insertGetId($insertData);
                SaasOrderFactory::updateStatus($saasOrderId, OrderConstant::ORDER_STATUS_LOAN_FINISHED);
            }

            return redirect()->route('admin.order.repaymanage.overduerepaying')->with('success', '成功！');
        }

        $saasOrderInfo = SaasOrderInterestRateFactory::getBySaasOrderId($saasOrderId);

        return view('admin.order.repaymanage.overdueRepayDetail', [
            'saasOrderInfo' => $saasOrderInfo
        ]);
    }
}
