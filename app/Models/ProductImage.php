<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    /**
     * Get the parent imageable model (e.g. Product).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */

    public function imageable()
    {
        return $this->morphTo();
    }
}
