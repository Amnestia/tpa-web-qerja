<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
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
        $currencies=[];
        for($i=0 ; $i<50 ; ++$i)
        {
            $curr=[];
            $curr['currency']=$faker->unique()->currencyCode;
            $curr['created_at'] = date('Y-m-d H:i:s');
            $curr['updated_at'] = date('Y-m-d H:i:s');
            array_push($currencies,$curr);
        }
        \App\Currency::insert($currencies);
    }
}
