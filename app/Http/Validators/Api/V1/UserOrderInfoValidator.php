<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class UserOrderInfoValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'order_no' => ['required','string'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'order_no.required' => '订单必须存在',
        'order_no.string' => '',
    );



    public function before()
    {

    }

}