<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function achievements()
    {
        return $this->hasMany(Achievment::class);
    }

    public function players()
    {
        return $this->belongsToMany(Account::class);
    }
}
