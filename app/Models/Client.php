<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'client_address',
        'client_city',
        'client_zipcode'
    ];
}
