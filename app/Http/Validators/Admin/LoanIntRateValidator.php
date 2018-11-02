<?php

namespace App\Http\Validators\Admin;

use App\Http\Validators\AbstractValidator;
use Illuminate\Support\Facades\Input;

class LoanIntRateValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'loan_amounts' => ['required', 'integer', 'min:1', 'digits_between:1,8'],
        'normal_day_rate' => ['required', 'numeric', 'min:0.000001','between:0.000001,99999999'],
        'service_rate' => ['nullable', 'numeric', 'min:0.000001', 'between:0.000001,99999999'],
        'overdue_daily_rate' => ['required', 'numeric', 'between:0.000001,99999999'],
        'lending_date' => ['required'],
        'repayment_date' => ['required', 'greater_than:lending_date'],

    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'loan_amounts.required' => '必填',
        'loan_amounts.digits_between' => '最长8个字符',
        'loan_amounts.integer' => '请输入正整数',
        'loan_amounts.min' => '请输入正整数',

        'normal_day_rate.required' => '必填',
        'normal_day_rate.numeric' => '请输入正数',
        'normal_day_rate.between' => '最长8个字符',
        'normal_day_rate.min' => '请输入正数',

        'service_rate.numeric' => '请输入正数',
        'service_rate.min' => '请输入正数',
        'service_rate.between' => '最长8个字符',
        'normal_day_rate.between' => '最长8个字符',
        'normal_day_rate.min' => '请输入正数',

        'overdue_daily_rate.required' => '必填',
        'overdue_daily_rate.numeric' => '请输入正数',
        'overdue_daily_rate.between' => '最长8个字符',

        'lending_date.required' => '必填',
        'repayment_date.required' => '必填',
        'repayment_date.greater_than' => '预计放款日期必须大于等于预计借款日期'
    );

    /**
     * 自定义验证规则或者扩展Validator类
     */
    public function before()
    {
        $this->extend('greater_than', function ($attribute, $value, $parameters) {
            $other = Input::get($parameters[0]);

            return $value >= $other;
        });
    }
}
