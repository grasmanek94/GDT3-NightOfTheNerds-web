<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'name'
    ];

    public function Scores()
	{
		return $this->hasMany(UserScore::class);
	}

	public function UnlockCodes()
	{
		return $this->hasManyThrough(UnlockCode::class, UserScore::class, 'user_id', 'id', 'id', 'unlock_code_id');
	}
}
