<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory,\LaravelTreats\Model\Traits\HasCompositePrimaryKey ;


    /**
     * Primary key of the table, composite of game and achievement name.
     * @var array
     */
    protected $primaryKey = ['game_key','name'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
