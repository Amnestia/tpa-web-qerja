<?php

use Illuminate\Database\Seeder;

class HelpfulSeeder extends Seeder
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
        $max_user=sizeof(\App\User::all());
        $min_user=\App\User::all()->first()->user_id;
        $min_pos=\App\Review::all()->first()->position_id;
        $max_pos=sizeof(\App\Review::all());

        $helpfuls=[];
        for($i=0 ; $i<100 ; ++$i)
        {
            $helpful=[];
            $helpful['user_id']=$faker->numberBetween($min_user,$max_user);
            $helpful['review_id']=$faker->numberBetween($min_pos,$max_pos);
            $helpful['created_at'] = date('Y-m-d H:i:s');
            $helpful['updated_at'] = date('Y-m-d H:i:s');
            array_push($helpfuls,$helpful);
        }
        \App\Helpful::insert($helpfuls);
    }
}
