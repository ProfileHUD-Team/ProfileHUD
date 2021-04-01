<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($account) {
            try{
                switch($account->platform){
                    case 'stm':
                        echo 'steam';
                        break;
                    case 'psn':
                        #psn api code
                        break;
                    case 'xbl':
                        #xbl api code
                        echo 'xbox';
                        break;
                    default:
                        echo 'There was an error. Please go back and try again.';
                }
            }
            catch(\Exception $exception){
                echo "Couldn't get platform info";
            }
        });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plays(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany((Game::class))->withPivot('hours_played');
    }

    public function achieves(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany((Achievement::class))->withPivot('is_earned','date_earned');
    }
}
