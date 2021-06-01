<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeSearch($query, $request)
    {
        if ($request->category) {
            $query->whereCategory_id($request->category);
        }

        if ($request->address) {
            $query->where('name', 'LIKE', "%$request->address%");
        }

        return $query;
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d F Y H:i", strtotime($value));
    }
}
