<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Field extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'html', 'enable', 'preview'];

    protected $searchableFields = ['*'];

    public function productDescriptions()
    {
        return $this->hasMany(ProductDescription::class);
    }
}
