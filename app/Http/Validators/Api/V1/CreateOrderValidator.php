<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class CreateOrderValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'bankId' => ['required','integer'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'bankId.required' => '所选银行必须存在',
    );

}