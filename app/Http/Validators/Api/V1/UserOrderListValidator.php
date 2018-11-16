<?php
namespace App\Http\Validators\Api\V1;

use App\Http\Validators\AbstractValidator;

class UserOrderListValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'page_index' => ['required','integer'],
        'page_size' => ['required','integer']
    );

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array(
        'page_index.required' => '',
        'page_index.integer' => '',
        'page_size.required' => '',
        'page_size.integer' => '',
    );



    public function before()
    {

    }

}