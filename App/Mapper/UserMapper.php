<?php

namespace App\Mapper;

use App\Model\User;

class UserMapper
{
    public static function mapToEntity(
        array $data
    ): User {

        return new User(

            $data['id'] ?? null,

            $data['name'],

            $data['email'],

            $data['password']
        );
    }
}