<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'store_category',
        'address',
        'is_active',
    ];

    /**
     * Get the sales for the store.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
