<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function show()
	{

		$scores = [];

		$users = User::leftJoinRelations('Scores')
			->groupBy('users.id')
			->selectRaw('users.*, count(user_scores.id) as unlock_count')
			->orderBy('unlock_count','desc')
			->orderBy('created_at','asc')
			->take(30)
			->get();

		foreach($users as $user)
		{
			$unlock = $user->UnlockCodes()->where('is_level_unlock', '=', true)->count();
			$bonus = $user->UnlockCodes()->where('is_level_unlock', '=', false)->count();
			$total = $unlock + $bonus;

			if($total > 0)
			{
				$scores[] = [
					'name' => $user->name,
					'unlock' => $unlock,
					'bonus' => $bonus,
					'total' => $total
				];
			}
		}

		return view('welcome')->with([
			'scores' => $scores
		]);
	}

	public function register($device_id)
	{

	}

	public function add_score($device_id, $score_id)
	{

	}
}
