<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'publicPlace',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'zipCode',
    ];
}
