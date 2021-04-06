<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function achievements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    public function players()
    {
        return $this->belongsToMany(Account::class);
    }
}
