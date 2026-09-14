<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'company_name',
        'email',
        'phone',
        'country',
        'billing_address',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
