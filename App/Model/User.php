<?php

namespace App\Model;

class User
{
    public static function registerRules(): array
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

    public static function loginRules(): array
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