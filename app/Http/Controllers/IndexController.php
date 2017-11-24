<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function show()
	{

		$scores = [];

		$users = User::all();
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

		usort($scores, function($a, $b) {
			return $b['total'] - $a['total'];
		});

		return view('welcome')->with([
			'scores' => array_slice($scores, 0, 30)
		]);
	}

	public function register($device_id)
	{

	}

	public function add_score($device_id, $score_id)
	{

	}
}
