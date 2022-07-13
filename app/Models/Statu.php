<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statu extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'color', 'client_id', 'event_id'];

    protected $searchableFields = ['*'];

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
