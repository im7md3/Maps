<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        
        return Carbon::parse($value)->diffForHumans();
    }

    public function avgRating()
    {
        return ($this->service_rating + $this->cleanliness_rating + $this->quality_rating + $this->pricing_rating) / 4;
    }

    public function likes(){
        return $this->belongsToMany(User::class,'likes');
    }
}
