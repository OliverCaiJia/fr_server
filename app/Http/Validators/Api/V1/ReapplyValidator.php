<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class ReapplyValidator extends AbstractValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'amount'  => ['required', 'string'],
        'term'  => ['required', 'integer'],
        'order_no'  => ['required', 'string'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'amount.required' => '请输入贷款金额',
        'amount.string' => '贷款金额应为字符串',
        'term.required' => '请输入贷款周期',
        'term.integer' => '贷款周期应为整数',
        'order_no.required' => '请输入订单编号',
        'order_no.string    ' => '订单编号应为字符串'
    );

}
