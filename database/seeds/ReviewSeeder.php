<?php

use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
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
        $reviews=[];
        $min=\App\Salary::all()->first()->salary_id;
        $max=sizeof(\App\Salary::all());
        $pros_min=\App\Pros::all()->first()->pros_id;
        $pros_max=sizeof(\App\Pros::all());
        $cons_min=\App\Cons::all()->first()->pros_id;
        $cons_max=sizeof(\App\Cons::all());

        for($i=0 ; $i<3000 ; ++$i)
        {
            $review=[];
            $review['salary_id']=rand($min,$max);
            $review['salary_rate']=rand(1,5);
            $review['career_rate']=rand(1,5);
            $review['balance_rate']=rand(1,5);
            $review['culture_rate']=rand(1,5);
            $review['management_rate']=rand(1,5);
            $pros=\App\Pros::find(rand($pros_min,$pros_max));
            if($pros)
            $review['positive_review']=$pros->pros;
            else
            $review['positive_review']=\App\Pros::find(1)->pros;
            $cons=\App\Cons::find(rand($cons_min,$cons_max));
            if($cons)
            $review['negative_review']=$cons->cons;
            else
            $review['negative_review']=\App\Cons::find(1)->cons;
            $review['created_at'] = date('Y-m-d H:i:s');
            $review['updated_at'] = date('Y-m-d H:i:s');
            array_push($reviews,$review);
        }
        foreach(array_chunk($reviews,1000) as $x)
        {
            \App\Review::insert($x);
        }
    }
}
