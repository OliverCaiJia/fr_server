<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class ProductUrlValidator extends AbstractValidator
{

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'product_id'  => ['required', 'integer'],
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'product_id.required'  => '产品ID必须存在',
        'product_id.integer'   => '产品ID必须是整数',
    );

}
