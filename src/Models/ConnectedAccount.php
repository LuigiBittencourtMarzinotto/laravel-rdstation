<?php

namespace LuigiBittencourtMarzinotto\RDStation\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectedAccount extends Model
{
    protected $table = 'rd_connected_accounts';

    public $timestamps = true;

    protected $fillable = [
        'account_id',
        'email',
        'access_token',
        'refresh_token',
        'expires_at',
        'token_type',
        'scope',
        'created_at',
        'updated_at',
    ];
}
