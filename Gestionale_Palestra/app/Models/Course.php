<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function users()
{
    return $this->belongsToMany(User::class)->withPivot('is_accepted');
}

public function activities()
{
    return $this->hasMany(Activity::class);
}

public function reservation()
{
    return $this->hasOne(Reservation::class);
}

}