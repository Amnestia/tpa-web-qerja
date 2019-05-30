<?php

use Illuminate\Database\Seeder;

class SalaryPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $periods=[
            ['period'=>'monthly','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['period'=>'yearly','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
        ];

        \App\SalaryPeriod::insert($periods);
    }
}
