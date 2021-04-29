<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Achievement: This model holds information on an achievement, and links it to the game it comes from and any
 * account that has played that game.
 * @author Gregory Dwyer
 * @package App\Http\Models
 */
class Achievement extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    /**
     * Defines achievement's relationship with games.
     */
    public function game(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Defines achievement's relationship with accounts.
     */
    public function achievers()
    {
        return $this->belongsToMany(Account::class)->withPivot('is_earned','date_earned');
    }


}
