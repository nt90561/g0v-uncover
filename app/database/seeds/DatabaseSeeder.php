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

		// old
		// $this->call('TruenameTableSeeder');
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


// old version
class TruenameTableSeeder extends Seeder {

	public function run()
	{
		if(!Schema::hasTable('judge')) {
			Schema::create('judge',function($table)
			{
				$table->increments('id');
				$table->string('name');
				$table->integer('year');
				$table->string('case');
				$table->integer('no');
				$table->string('date', 7);
				$table->string('cause');
			});
		}

		// file path
		$file_array = file('app/database/seeds/output.txt');
		$count = 0;

		$name_array;
		$case_array;
		$date;
		$cause;
		foreach($file_array as $key => $value)
		{
		    if(($key % 4) == 0) {
		        $name_array = explode(', ', str_replace('"', '', substr(trim($value), strpos($value, '[') + 1, -2)));
		    } else if(($key % 4) == 1) {
		        $case_array = explode(',', substr(trim($value), strpos($value, '"') + 1, -2));
		    } else if(($key % 4) == 2) {
		        $date = substr($value, strpos(trim($value), '"') + 1, -2);
		    } else if(($key % 4) == 3) {
		        $cause = substr($value, strpos(trim($value), '"') + 1, -2);
		        foreach($name_array as $name) {
		        	// for console, not necessary
		        	print_r(array(
	        			'name' => $name,
	        			'year' => $case_array[0],
	        			'case' => $case_array[1],
	        			'no' => $case_array[2],
	        			'date' => $date,
	        			'cause' => $cause
		        	));

		        	// insert
		        	DB::table('judge')->insert(
		        		array(
		        			'name' => $name,
		        			'year' => $case_array[0],
		        			'case' => $case_array[1],
		        			'no' => $case_array[2],
		        			'date' => $date,
		        			'cause' => $cause
		        		)
		        	);
		        }
		    }

		}

	}
}