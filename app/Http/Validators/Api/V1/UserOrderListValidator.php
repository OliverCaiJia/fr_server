<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class UserOrderListValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'page_index' => ['required','integer'],
        'page_size' => ['required','integer']
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'page_index.required' => '请输入起始页',
        'page_index.integer' => '起始页应为整数',
        'page_size.required' => '请输入每页数',
        'page_size.integer' => '每页数应为整数',
    );



    public function before()
    {

    }

}