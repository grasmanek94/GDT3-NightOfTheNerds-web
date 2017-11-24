<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
	protected $fillable = [
		'user_id', 'unlock_code_id'
	];

	public function UnlockCode()
	{
		return $this->belongsTo(UnlockCode::class);
	}

	public function User()
	{
		return $this->belongsTo(User::class);
	}
}
