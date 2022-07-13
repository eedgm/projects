<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDescription extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['label', 'product_id', 'field_id'];

    protected $searchableFields = ['*'];

    protected $table = 'product_descriptions';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
