<?php

namespace Marktstand\Checkout;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Marktstand\Product\Product;
use Marktstand\Users\Producer;
use Marktstand\Users\Supplier;

class CartItem extends Model
{
    /**
     * The eager loaded models.
     *
     * @var array
     */
    protected $with = [
        'product.thumbnail', 'supplier.user.company.logo', 'supplier.user', 'producer.company',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    /**
     * Get the supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the producer.
     */
    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    /**
     * Get the product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get items total.
     *
     * @return int
     */
    public function getTotalAttribute()
    {
        return $this->quantity * $this->product->price()->total();
    }

    /**
     * Get the vat factor.
     *
     * @return int
     */
    public function getVatAttribute()
    {
        return $this->product->vat;
    }
}
