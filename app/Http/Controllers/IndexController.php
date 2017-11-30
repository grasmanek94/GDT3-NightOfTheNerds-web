<?php

namespace App\Http\Controllers;

use App\User;
use App\UnlockCode;
use App\UserScore;
use Exception;

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
					'total' => $unlock * 4 + $bonus
				];
			}
		}

		usort($scores, function($a, $b) {
			return $b['total'] - $a['total'];
		});

		return view('welcome')->with([
			'scores' => $scores
		]);
	}

	public function register($device_id)
	{
		$user = User::register($device_id);

		return [
			'success' => true,
			'id' => $user->id,
			'device_id' => $user->device_id,
			'name' => $user->name,
			'created_at' => $user->created_at,
			'updated_at' => $user->updated_at
		];
	}

	public function add_score($device_id, $score_id)
	{
		$user = User::register($device_id);

		$real_score_id = $this->decrypt($score_id, $device_id);
		$score_id = $real_score_id;

		$score = UnlockCode::where('code', '=', $score_id)->first();
		if($score == null)
		{
			return [
				'success' => false
			];
		}

		if($user->Scores()->where('unlock_code_id', '=', $score->id)->first() != null)
		{
			return [
				'success' => false
			];
		}

		try
		{
			$user->Scores()->save(UserScore::create(['user_id' => $user->id, 'unlock_code_id' => $score->id]));
		}
		catch(Exception $e)
		{

			return [
				'success' => false
			];
		}

		return [
			'success' => true
		];
	}

	public function get_score($device_id, $score_id)
	{
		$real_score_id = $this->encrypt($score_id, $device_id);
		$score_id = $real_score_id;
		return [
			'score_id' => $score_id
		];
	}

	// PHP: Encrypt Code:
	public static function addpadding($string, $blocksize = 32)
	{
		$len = strlen($string);
		$pad = $blocksize - ($len % $blocksize);
		$string .= str_repeat(chr($pad), $pad);
		return $string;
	}
	public static function encrypt($string = "", $key)
	{
		$iv = base64_decode("DWY6GHpKTc+ycZ+XCMFznML7nTCd3LnHk+7bQCwYKmQ=");
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, self::addpadding($string), MCRYPT_MODE_CBC, $iv));
	}

	// PHP:Decrypt Code:
	public static function strippadding($string)
	{
		$slast = ord(substr($string, -1));
		$slastc = chr($slast);
		$pcheck = substr($string, -$slast);
		if(preg_match("/$slastc{".$slast."}/", $string)){
			$string = substr($string, 0, strlen($string)-$slast);
			return $string;
		} else {
			return false;
		}
	}
	public static function decrypt($string, $key)
	{
		$iv = base64_decode("DWY6GHpKTc+ycZ+XCMFznML7nTCd3LnHk+7bQCwYKmQ=");
		$string = base64_decode($string);
		return self::strippadding(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv));
	}
}
