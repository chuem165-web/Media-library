<?php

namespace App\Http\Request;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'email' => [

                'required' => true,

                'email' => true
            ],

            'password' => [

                'required' => true
            ]
        ];
    }
}