<?php

namespace App\Http\Request;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'name' => [

                'required' => true,

                'min' => 3,

                'max' => 50
            ],

            'email' => [

                'required' => true,

                'email' => true
            ],

            'password' => [

                'required' => true,

                'min' => 6
            ]
        ];
    }
}