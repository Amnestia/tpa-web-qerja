<?php

use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker=Faker\Factory::create();
        $min_pos=\App\Position::all()->first()->position_id;
        $max_pos=sizeof(\App\Position::all());
        $currency_min=\App\Currency::all()->first()->currency_id;
        $currency_max=sizeof(\App\Currency::all());
        $jobs=[];
        for($i=0 ; $i<3000 ; ++$i)
        {
            $job=[];
            $job['position_id']=$faker->numberBetween($min_pos,$max_pos);
            $job['currency_id']=$faker->numberBetween($currency_min,$currency_max);
            $job['salary']=rand(4000000,20000000);
            $job['description']=$faker->catchPhrase;
            $job['created_at'] = date('Y-m-d H:i:s');
            $job['updated_at'] = date('Y-m-d H:i:s');
            array_push($jobs,$job);
        }
        foreach (array_chunk($jobs,500) as $x)
        {
            \App\Job::insert($x);
        }
    }
}
