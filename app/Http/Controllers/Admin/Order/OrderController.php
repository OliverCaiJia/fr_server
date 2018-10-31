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
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use App\Models\Orm\SaasOrderSaas;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserReport;
use App\Strategies\CertifyTaobaoStrategy;
use App\Strategies\OrderStrategy;
use App\Strategies\SaasPersonStrategy;
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
        $ageLow = $request->input('age_low');
        $ageHigh = $request->input('age_high');
        $province = $request->input('province');

        $query = UserOrder::leftJoin(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->leftJoin(UserReport::TABLE_NAME, UserReport::TABLE_NAME . '.id', UserOrder::TABLE_NAME . '.user_report_id')
            ->select(
                UserOrder::TABLE_NAME . '.*',
                SaasOrderSaas::TABLE_NAME.'.id as saas_order_id',
                UserReport::TABLE_NAME . '.age',
                UserReport::TABLE_NAME . '.province',
                SaasOrderSaas::TABLE_NAME . '.assigned_at'
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
        });

        $operatorIds = SaasPersonStrategy::getSubIdsById(Auth::user()->id);
        $orders = $orders->whereIn(SaasOrderSaas::TABLE_NAME . '.person_id', $operatorIds)
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

        $orders = UserOrder::leftJoin(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->leftJoin(UserReport::TABLE_NAME, UserReport::TABLE_NAME . '.id', UserOrder::TABLE_NAME . '.user_report_id')
            ->select([UserOrder::TABLE_NAME . '.*', 'age', 'province', SaasOrderSaas::TABLE_NAME . '.assigned_at'])
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
            });

        $operatorIds = SaasPersonStrategy::getSubIdsById(Auth::user()->id);
        $orders = $orders->whereIn(SaasOrderSaas::TABLE_NAME . '.person_id', $operatorIds)
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

        $orders = UserOrder::join(SaasOrderSaas::TABLE_NAME, 'order_id', UserOrder::TABLE_NAME . '.id')
            ->join(UserReport::TABLE_NAME, UserReport::TABLE_NAME . '.id', UserOrder::TABLE_NAME . '.user_report_id')
            ->select([UserOrder::TABLE_NAME . '.*', 'age', 'province', SaasOrderSaas::TABLE_NAME . '.assigned_at'])
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
            ->select(SaasOrderSaas::TABLE_NAME.'.id as saas_order_id', SaasOrderSaas::TABLE_NAME . '.status', 'user_report_id', UserOrder::TABLE_NAME . '.id', SaasOrderSaas::TABLE_NAME . '.created_at', SaasOrderSaas::TABLE_NAME . '.assigned_at', 'saas_channel_detail', 'source', SaasOrderSaas::TABLE_NAME . '.order_price', UserReport::TABLE_NAME . '.age', UserReport::TABLE_NAME . '.province');

        $query->selectRaw(env('DB_PREFIX') . SaasOrderSaas::TABLE_NAME . '.order_price as price');

        $query = $query->when($start, function ($query) use ($start, $end) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.assigned_at', '>=', $start);
        })->when($end, function ($query) use ($end) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.assigned_at', '<=', $end);
        })->when($status, function ($query) use ($status) {
            return $query->where(SaasOrderSaas::TABLE_NAME . '.status', $status);
        })->when($province, function ($query) use ($province) {
            return $query->where(UserReport::TABLE_NAME . '.province', $province);
        })->when($userFilter, function ($query) use ($orderIds) {
            return $query->whereIn(SaasOrderSaas::TABLE_NAME . '.order_id', $orderIds);
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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $order = OrderFactory::getDetail($id);
        $personIds = SaasPersonStrategy::getPersonIdsByUserId(Auth::user()->id);
        $status = SaasOrderFactory::getStatusByOrderIdAndPersonIds($id, $personIds);
        $taobaoId = $order->userReport->taobao_id;
        $taobaoInfo = CertifyTaobaoStrategy::getAndDealTaobaoInfoById($taobaoId);

        return view('admin.order.detail', compact('order', 'status', 'taobaoInfo'));
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
}
