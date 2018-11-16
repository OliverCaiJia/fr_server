<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;
use App\Models\Factory\Api\UserOrderFactory;

class CreateOrderValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'order_type_nid' => ['required','string','is_order_type_nid'],
//        'terminal_nid' => ['required','string'],
        'amount' => ['required','numeric'],
        'count' => ['required','integer'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'order_type_nid.required' => '订单类型必须存在',
        'order_type_nid.is_order_type_nid' => '订单类型不合法',
//        'terminal_nid.required' => '终端标识必须存在',
        'amount.required' => '订单金额必须是数字',
        'count.required' => '订单数量必须是整数',
    );



    public function before()
    {
        $this->extend('is_order_type_nid', function($attribute, $value, $parameters)
        {
            $userOrderType = UserOrderFactory::getOrderTypeByTypeNid($value);
            if (!empty($userOrderType))
            {
                return true;
            }
            return false;
        });

    }

}