<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['platform', 'game_id', 'developer', 'publisher', 'release_date', 'name'];

    public function achievements()
    {
        return $this->hasMany(Achievment::class);
    }

    public function players()
    {
        return $this->belongsToMany(Account::class);
    }
}
