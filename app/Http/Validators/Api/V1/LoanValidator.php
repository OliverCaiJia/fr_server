<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class LoanValidator extends AbstractValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'terminalType'  => ['required', 'integer'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'terminalType.required'  => '终端类型必须存在',
        'terminalType.integer'   => '终端类型必须是整数',
    );

}
