<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rack extends Model
{
    use HasFactory;

    protected $fillable = ['code'];
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}
