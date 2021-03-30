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

        static::creating(function ($account) {
            try{
                switch($account->platform){
                    case 'stm':
                        #steam api code
                        break;
                    case 'psn':
                        #psn api code
                        break;
                    case 'xbl':
                        #xbl api code
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function games()
    {
        return $this->hasMany((Game::class));
    }
}
