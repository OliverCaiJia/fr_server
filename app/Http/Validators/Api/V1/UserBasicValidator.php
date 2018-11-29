<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class UserBasicValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'user_location' => ['required'],
        'user_address' => ['required'],
        'zhima_score' => ['required'],
        'house_fund_time' => ['required'],
        'profession' => ['required'],
        'has_social_security' => ['required'],
        'has_house' => ['required'],
        'has_auto' => ['required'],
        'has_assurance' => ['required'],
        'has_house_fund' => ['required'],
        'has_weilidai' => ['required'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'user_location.required' => '必须填写',
        'user_address' => '必须填写',
        'zhima_score.required' => '必须填写',
        'house_fund_time.required' => '必须填写',
        'profession.required' => '必须填写',
        'has_social_security.required' => '必须填写',
        'has_house.required' => '必须填写',
        'has_auto.required' => '必须填写',
        'has_assurance.required' => '必须填写',
        'has_house_fund.required' => '必须填写',
        'has_weilidai.required' => '必须填写',
    );


}