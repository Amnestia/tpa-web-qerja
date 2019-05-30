<?php

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
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
        $filename=[
          'company_1.png',
          'company_2.png',
          'company_3.png',
          'company_4.png',
          'company_5.png',
          'company_6.png',
          'company_7.png',
          'company_8.png',
        ];
        $companies=[];
        $min=\App\Category::all()->first()->category_id;
        $max=sizeof(\App\Category::all());
        for($i=0 ; $i<126; ++$i)
        {
            $company=[];
            $company['name']=$faker->company;
            $company['website']=$faker->unique()->domainName;
            $company['description'] = $faker->catchPhrase.' '.$faker->text;
            $company['email'] = $faker->unique()->safeEmail;
            $company['location'] = $faker->streetAddress;
            $company['phone'] = $faker->e164PhoneNumber;
            $company['image']=$filename[rand(0,7)];
            $company['category_id']=rand($min,$max);
            $company['country_id'] = rand(1, 224);
            $company['city_id'] = rand(\App\City::where('country_id',$company['country_id'])->first()->city_id, \App\City::where('country_id',$company['country_id'])->orderBy('city_id','desc')->first()->city_id);
            $company['created_at'] = date('Y-m-d H:i:s');
            $company['updated_at'] = date('Y-m-d H:i:s');
            array_push($companies,$company);
        }

        \App\Company::insert($companies);
    }
}
