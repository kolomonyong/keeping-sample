<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'batch', 'description', 'shelf_life_days'];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}
