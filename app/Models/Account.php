<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

/**
 * Model Account: This model holds the indentifying information for a gaming account/profile. It is related to a single
 * user and any number of games and achievements.
 * @author Gregory Dwyer
 * @package App\Http\Models
 */
class Account extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Defines account's relationship with user.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines account's relationship with games.
     */
    public function plays(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Game::class)->withPivot('hours_played');
    }

    /**
     * Defines account's relationship with achievements.
     */
    public function achieves(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Achievement::class)->withPivot('is_earned','date_earned');
    }
}
