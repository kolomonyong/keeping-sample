<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_type_id',
        'rack_id',
        'production_code',
        'batch',
        'quantity',
        'production_date',
        'expiration_date',
        'remark',
        'status',
        'unique_sample_id',
    ];

    public function rack(): BelongsTo
    {
        return $this->belongsTo(Rack::class);
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function defectiveReports(): HasMany
    {
        return $this->hasMany(DefectiveProduct::class);
    }
    public function histories(): HasMany
    {
        return $this->hasMany(StockHistory::class)->latest();
    }
}
