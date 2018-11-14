<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class CreateOrderValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'order_type' => ['required','integer'],
        'terminal_nid' => ['required','string'],
        'amount' => ['required','numeric'],
        'count' => ['required','integer'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'order_type.required' => '订单类型必须是整数',
        'terminal_nid.required' => '终端标识必须存在',
        'amount.required' => '订单金额必须是数字',
        'count.required' => '订单数量必须是整数',
    );

}