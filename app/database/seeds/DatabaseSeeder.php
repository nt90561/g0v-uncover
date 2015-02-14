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

		$this->call('JudgementTableSeeder');
	}

}

class JudgementTableSeeder extends Seeder {

	public function run()
	{

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
				DB::table('judgements')->insert(
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