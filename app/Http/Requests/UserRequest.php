<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            $rule =  [
                'name' => 'required|max:255',
                'username' => 'required|unique:saas_persons|max:255',
                'department' => 'required|max:255',
                'password' => 'required|confirmed|min:8|max:16|alpha_num',
                'role' => 'required'
            ];
        } else {
            $id = $this->route('user');

            $rule = [
                'name' => 'required|max:255',
                'username' => 'required|unique:saas_persons,username,' . $id . '|max:255',
                'department' => 'required|max:255',
                'password' => 'confirmed',
                'role' => 'required'
            ];
            if ($this->input('password')) {
                $rule['password'] = 'required|confirmed|min:8|max:16|alpha_num';
            }
        }

        if ($this->input('email')) {
            $rule['email'] = 'email';
        }

        if ($this->input('mobilephone')) {
            $rule['mobilephone'] = 'numeric|digits_between:11,15';
        }

        return $rule;
    }
}
