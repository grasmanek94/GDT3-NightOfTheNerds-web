<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSha256HashesToCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('unlock_codes', function (Blueprint $table) {
			$table->string('hash');
		});

		$unlock_codes = App\UnlockCode::all();

		foreach($unlock_codes as $unlock_code)
		{
			$unlock_code->hash = hash('sha256', $unlock_code->code, false);
			$unlock_code->save();
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('unlock_codes', function (Blueprint $table) {
			$table->dropColumn('hash');
		});
    }
}
