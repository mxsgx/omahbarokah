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
        $rules = [
            'name' => [
                'required', 'string',
            ],
            'email' => [
                'required', 'email',
            ],
            'role' => [
                'required', 'in:admin,staff,client',
            ],
        ];

        if ($this->getMethod() === 'POST') {
            $rules['email'][] = 'unique:users,email';
            $rules['password'] = [
                'required', 'string', 'min:5',
            ];
        }

        return $rules;
    }
}
