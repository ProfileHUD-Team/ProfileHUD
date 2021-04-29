<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Game: This model holds information on games and links to its achievements and any account that has played it.
 * @author Gregory Dwyer
 * @package App\Http\Models
 */
class Game extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    /**
     * Defines Game's relationship with achievements.
     */
    public function achievements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    /**
     * Defines game's relationship with accounts.
     */
    public function players()
    {
        return $this->belongsToMany(Account::class);
    }
}
