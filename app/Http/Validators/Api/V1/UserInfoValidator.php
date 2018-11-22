<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class UserInfoValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'profession' => ['required','integer'],
        'work_time' => ['required','integer'],
        'month_salary' => ['required','integer'],
        'zhima_score' => ['required','integer'],
        'house_fund_time' => ['required','integer'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'profession.required' => '必须填写',
        'work_time.required' => '必须填写',
        'month_salary.required' => '必须填写',
        'zhima_score.required' => '必须填写',
        'house_fund_time.required' => '必须填写',
    );



    public function before()
    {

    }

}