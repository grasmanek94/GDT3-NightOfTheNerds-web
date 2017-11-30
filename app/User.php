<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Sofa\Eloquence\Eloquence;

class User extends Authenticatable
{
	use Eloquence;
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

	public function UnlockCodesLevel()
	{
		return $this->UnlockCodes()->where('is_level_unlock', '=', true);
	}

	public function UnlockCodesBonus()
	{
		return $this->UnlockCodes()->where('is_level_unlock', '=', false);
	}

	public function getUnlockCodesLevelCountAttribute()
	{
		return $this->UnlockCodesLevel()->count();
	}

	public function getUnlockCodesBonusCountAttribute()
	{
		return $this->UnlockCodesBonus()->count();
	}

	public static function register($device_id)
	{
		$user = User::where('device_id', '=', $device_id)->first();
		if($user != null)
		{
			return $user;
		}

		return User::create(['device_id' => $device_id, 'name' => '']);
	}
}
