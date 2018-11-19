<?php

namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

/**
 * @author zhaoqiying
 */
class QuickloginValidator extends AbstractValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'mobile'   => ['required','is_phone'],
	    'sign'     => ['required','alpha_num','size:32']
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'mobile.required' => '登录名必须输入',
        'mobile.is_phone' => '请输入正确的手机号格式',
	    'code.required' => '验证码必须传值',
	    'code.integer' => '验证码必须是整数',
	    'sign.size' => 'sign必须是32位',
    );

    /*
     * 自定义验证规则或者扩展Validator类
     */

    public function before()
    {
	    //自定义规则检查用户手机号
	    $this->extend('is_phone',function($attribute,$value,$paramters){
	    	if (preg_match('/^1[3|4|5|6|7|8|9]\d{9}$/', $value)) {
	    		return true;
		    } else {
		    	return false;
		    }
	    });
    }

}
