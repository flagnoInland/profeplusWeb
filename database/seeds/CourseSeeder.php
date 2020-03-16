<?php

class CourseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Eloquent::unguard();
        DB::table('profeplus_courses')->delete();
        
        Course::create(array(
            'user_id' => 1,
            'name' => 'Test Course',
            'courseid' => 'TC006699',
            'institution' => 'Unknown',
            'country' => 'U.S.A.',
            'speciality' => 'Testing',
            'term' => 'None',
            'timeload' => 'None',
            'students' => '999',
            'label' => 'TC006699',
        ));
	}

}