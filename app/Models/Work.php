<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Work extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'product_id',
        'date_start',
        'date_end',
        'hours',
        'cost',
        'statu_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function statu()
    {
        return $this->belongsTo(Status::class, 'statu_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
