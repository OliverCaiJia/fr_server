<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class UserOrderStatusValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
//        'page_index' => ['required','integer'],
//        'page_size' => ['required','integer'],
        'order_no' => ['required','string'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
//        'page_index.required' => '',
//        'page_index.integer' => '',
//        'page_size.required' => '',
//        'page_size.integer' => '',
        'order_no.required' => '订单必须存在',
        'order_no.string' => '',
    );



    public function before()
    {

    }

}