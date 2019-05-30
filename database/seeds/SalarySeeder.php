<?php

use Illuminate\Database\Seeder;

class SalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $salaries=[];
        $company_min=\App\Company::all()->first()->company_id;
        $company_max=sizeof(\App\Company::all());
        $salary_period_min=\App\SalaryPeriod::all()->first()->salary_period_id;
        $salary_period_max=sizeof(\App\SalaryPeriod::all());
        $period_min=\App\Period::all()->first()->period_id;
        $period_max=sizeof(\App\Period::all());
        $currency_min=\App\Currency::all()->first()->currency_id;
        $currency_max=sizeof(\App\Currency::all());

        for($i=0 ; $i<3000 ; ++$i)
        {
            $salary=[];
            $salary['company_id']=rand($company_min,$company_max);
            $salary['position_id']=rand(\App\Position::where('company_id',$salary['company_id'])->orderBy('position_id')->first()->position_id,\App\Position::where('company_id',$salary['company_id'])->orderBy('position_id','desc')->first()->position_id);
            $salary['salary_period_id']=rand($salary_period_min,$salary_period_max);
            $salary['period_id']=rand($period_min,$period_max);
            $salary['currency_id']=rand($currency_min,$currency_max);
            $salary['salary']=rand(3000000,100000000);
            $salary['created_at'] = date('Y-m-d H:i:s');
            $salary['updated_at'] = date('Y-m-d H:i:s');
            $x=rand(1,5);
            for($j=0 ; $j<$x ; ++$j)
            {
                $salary['salary']=rand(3000000,100000000);
                array_push($salaries,$salary);
            }
        }

        foreach (array_chunk($salaries,1000) as $x)
        {
            \App\Salary::insert($x);
        }
    }
}
