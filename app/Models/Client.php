<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'owner',
        'phone',
        'name',
        'website',
        'logo',
        'direction',
        'user_id',
        'cost_hour',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function status()
    {
        return $this->hasMany(Status::class);
    }
}
