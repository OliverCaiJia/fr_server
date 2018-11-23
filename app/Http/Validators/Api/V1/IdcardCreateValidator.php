<?php

namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

/*
 *
 * 身份证信息提交验证
 */

class IdcardCreateValidator extends AbstractValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'id_card_no' => ['required','regex:/^[a-zA-Z0-9]{15,18}$/'],
        'id_card_front_img' => ['required','url'],
        'id_card_back_img' => ['required','url'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'id_card_no.required' => '身份证号参数id_card_no必填',
        'id_card_no.regex' => '身份证号格式错误',
        'id_card_front_img.required' => '身份证正面照片url参数必填',
        'id_card_front_img.url' => '身份证正面照片url格式错误',
        'id_card_back_img.required' => '身份证背面照片url参数必填',
        'id_card_back_img.url' => '身份证背面照片url格式错误',
    );


}
