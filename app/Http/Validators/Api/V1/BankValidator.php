<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class BankValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'bankcard' => ['required','regex:/^[0-9]{16,19}$/'],
        'mobile' => ['required', 'regex:/^1[3|4|5|6|7|8|9]\d{9}$/'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'bankcard.required' => '银行账号参数bankcard必填',
        'bankcard.regex' => '银行账号格式错误',
        'mobile.required' => '手机号必填!',
        'mobile.regex' => '手机号格式不正确，请重新输入',
    );

}