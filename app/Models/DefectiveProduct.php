<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DefectiveProduct extends Model
{
    use HasFactory;
    protected $fillable = ['stock_id', 'reason', 'reported_at', 'reported_by_id']; // Ditambahkan

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by_id');
    }
}
