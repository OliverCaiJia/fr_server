<?php

namespace App\Http\Validators\Admin;

use App\Http\Validators\AbstractValidator;
use Illuminate\Support\Facades\Input;

class OverdueRepayDetailValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'repayment_date' => ['required'],
        'repayment_amount' => ['required', 'numeric', 'min:0.000001', 'between:0.000001,99999999'],


    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'repayment_amount.required' => '必填',
        'repayment_amount.between' => '最长8个字符',
        'repayment_amount.numeric' => '请输入正数',
        'repayment_amount.min' => '请输入正数',

        'repayment_date.required' => '必填',
    );
}
