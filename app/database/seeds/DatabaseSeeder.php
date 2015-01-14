<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('FirstSectionTableSeeder');
	}

}

class FirstSectionTableSeeder extends Seeder {

	public function run()
	{
		if(!Schema::hasTable('judge')) {
			Schema::create('judge',function($table)
			{
				$table->increments('id');
				$table->string('name');
				$table->string('court');
				$table->integer('year');
				$table->string('case');
				$table->integer('no');
				$table->string('date', 7);
				$table->string('cause');
			});
		}

		$name_array;
		$case_array;
		$court;
		$date;
		$cause;

		// file path
		$file = fopen('app/database/seeds/output.csv', 'r');


		while(!feof($file)) {
			$entry = fgetcsv($file);
			$name_array = explode(';', $entry[5]);
			$case_array = explode(',', $entry[1]);
			$court = $entry[3];
			$date = $entry[2];
			$cause = $entry[4];

			foreach($name_array as $name) {
				// for console display, not necessary
				print_r(array(
					'name' => $name,
					'year' => $case_array[0],
					'court' => $court,
					'case' => $case_array[1],
					'no' => $case_array[2],
					'date' => $date,
					'cause' => $cause
				));

				// insert query
				DB::table('judge')->insert(
					array(
						'name' => $name,
						'year' => $case_array[0],
						'court' => $court,
						'case' => $case_array[1],
						'no' => $case_array[2],
						'date' => $date,
						'cause' => $cause
					)
				);
			}

		}

		fclose($file);
	}
}