<?php

use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
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
        $positions=[];
        $min=\App\Company::all()->first()['company_id'];
        $max=sizeof(\App\Company::all());
        for($i=0 ; $i<10000; ++$i)
        {
            $pos=[];
            $pos['position']=$faker->jobTitle();
            $pos['company_id']=rand($min,$max);
            $pos['created_at'] = date('Y-m-d H:i:s');
            $pos['updated_at'] = date('Y-m-d H:i:s');
            array_push($positions,$pos);
        }
        foreach(array_chunk($positions,500) as $x)
        {
            \App\Position::insert($x);
        }

    }
}
