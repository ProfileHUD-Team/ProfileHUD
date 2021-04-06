<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function game(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function achievers()
    {
        return $this->belongsToMany(Account::class)->withPivot('is_earned','date_earned');
    }


}
