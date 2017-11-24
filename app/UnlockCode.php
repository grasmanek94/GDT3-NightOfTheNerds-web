<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnlockCode extends Model
{
	protected $fillable = [
		'code', 'data', 'is_level_unlock', 'description'
	];

	public function UserScores()
	{
		return $this->hasMany(UserScore::class);
	}

	public function Users()
	{
		return $this->hasManyThrough(User::class, UserScore::class, 'unlock_code_id', 'id', 'id', 'user_id');
	}

	static public function Random()
	{
		$arr = ['A', 'B', 'C', 'D', 'E', 'F', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
		$res = "";
		for($i = 0; $i < 41; ++$i)
		{
			$res .= $arr[rand(0, count($arr))];
		}

		return $res;
	}
}
