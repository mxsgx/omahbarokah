<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'stock', 'price', 'description', 'is_private',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'thumbnail', 'price_rupiah', 'stock_availability',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'stock' => 'integer',
        'price' => 'decimal:0',
        'is_private' => 'boolean',
    ];

    /**
     * Get the product's stock availability.
     *
     * @return string.
     */
    public function getStockAvailabilityAttribute()
    {
        return $this->stock > 0 ? "Tersedia" : "Kosong";
    }

    /**
     * Get the product's price in Rupiah currency.
     *
     * @return string.
     */
    public function getPriceRupiahAttribute()
    {
        return "Rp " . number_format($this->price, 2, ',', '.');
    }

    /**
     * Get the product's thumbnail.
     *
     * @return string|null
     */
    public function getThumbnailAttribute()
    {
        $theThumbnail = Meta::product($this->id, '_thumbnail');

        return !is_null($theThumbnail) ? url($theThumbnail->value) : null;
    }
}
