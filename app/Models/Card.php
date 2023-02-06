<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public function collections() {
        return $this->belongsToMany(Collection::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
