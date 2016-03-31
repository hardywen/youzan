<?php

namespace Hardywen\Youzan\Models;


use Illuminate\Database\Eloquent\Model;

class YouzanUser extends Model
{
    protected $table = 'youzan_users';

    protected $fillable = [
        'owner_type',
        'owner_id',
        'user_id',
        'nick_name',
        'avatar',
        'access_token',
        'expires_in',
        'expires_at',
        'token_type',
        'scope',
        'refresh_token'
    ];
}