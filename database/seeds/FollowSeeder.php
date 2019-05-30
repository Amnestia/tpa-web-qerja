<?php

use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
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
        $follows=[];
        $umin=\App\User::all()->first()->user_id;
        $umax=sizeof(\App\User::all());
        $cmin=\App\Company::all()->first()->company_id;
        $cmax=sizeof(\App\Company::all());
        for($i=0 ; $i<100 ; ++$i)
        {
            $follow=[];
            $follow['user_id']=$faker->numberBetween($umin,$umax);
            $follow['company_id']=$faker->numberBetween($cmin,$cmax);
            $follow['created_at'] = date('Y-m-d H:i:s');
            $follow['updated_at'] = date('Y-m-d H:i:s');
            array_push($follows,$follow);
        }
        \App\Follow::insert($follows);
    }
}
