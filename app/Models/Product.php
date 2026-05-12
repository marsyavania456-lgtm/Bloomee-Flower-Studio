<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];

    public static $categories = [
        'Rose'     => '🌹 Rose',
        'Tulip'    => '🌷 Tulip',
        'Lily'     => '🌸 Lily',
        'Orchid'   => '💜 Orchid',
        'Sunflower'=> '🌻 Sunflower',
        'Mixed'    => '💐 Mixed Bouquet',
        'Wreath'   => '🎀 Wreath',
        'Gift'     => '🎁 Gift Set',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image && \Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}