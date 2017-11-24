<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\UnlockCode;
use App\User;

class UserScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('unlock_codes', function (Blueprint $table) {
			$table->increments('id');

			$table->string('code')->unique();
			$table->string('data', 8192)->default('');
			$table->boolean('is_level_unlock')->default(false);
			$table->string('description')->default('');

			$table->timestamps();
		});

		Schema::create('user_scores', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users');

			$table->integer('unlock_code_id')->unsigned()->index();
			$table->foreign('unlock_code_id')->references('id')->on('unlock_codes');

			$table->timestamps();
		});

		for ($i = 0; $i < 30;)
		{
			try
			{
				$code = UnlockCode::Random();
				$code[22] = '1';

				UnlockCode::create(['code' => $code, 'is_level_unlock' => 1]);
				++$i;
			} catch (Exception $e)
			{

			}
		}

		for ($i = 0; $i < 30;)
		{
			try
			{
				$code = UnlockCode::Random();
				$code[22] = '0';

				UnlockCode::create(['code' => $code, 'is_level_unlock' => 0]);
				++$i;
			} catch (Exception $e)
			{

			}
		}

		/*for ($i = 0; $i < 5000; ++$i)
		{
			$user = User::create(['device_id' => $i, 'name' => $i]);

			for ($j = 0, $k = rand(7, 30); $j < $k; ++$j)
			{
				$unlock_code = UnlockCode::inRandomOrder()->first();

				$user->Scores()->save(App\UserScore::create(['user_id' => $user->id, 'unlock_code_id' => $unlock_code->id]));
			}
		}*/
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('user_scores');
		Schema::dropIfExists('unlock_codes');
    }
}
