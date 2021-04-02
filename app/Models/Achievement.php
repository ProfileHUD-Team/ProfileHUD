<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function achievers()
    {
        return $this->belongsToMany(Account::class)->withPivot('is_earned','date_earned');
    }


}
