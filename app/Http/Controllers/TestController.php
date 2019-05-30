<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Helpful;
use App\Job;
use App\Position;
use App\Review;
use App\Salary;
use Illuminate\Http\Request;
use App\Company;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //
    public function test()
    {
        $reviews=Review::join('salaries','salaries.salary_id','reviews.salary_id')->
        join('positions','salaries.position_id','positions.position_id')->
        join('companies','salaries.company_id','companies.company_id')->
        select('salaries.salary_id',
            'companies.company_id',
            'companies.name',
            'companies.image',
            'positions.position_id',
            'positions.position',
            'reviews.positive_review',
            'reviews.negative_review',
            'reviews.review_id',
            'reviews.salary_rate',
            'reviews.career_rate',
            'reviews.balance_rate',
            'reviews.culture_rate',
            'reviews.management_rate',
            'reviews.created_at')->
        groupBy(['companies.company_id','positions.position_id'])->latest('reviews.created_at')->get();
        $reviews->each(function($r){
            $r['average_rating']=($r['salary_rate']+$r['balance_rate']+$r['career_rate']+$r['culture_rate']+$r['management_rate'])/5;
            $count=Helpful::where('review_id',$r['review_id'])->whereNull('deleted_at')->groupBy('review_id')->count();
            $r['count']=$count;
        });
        $salary=Salary::join('positions','salaries.position_id','positions.position_id')->
                        join('companies','salaries.company_id','companies.company_id')->
                        join('currencies','salaries.currency_id','currencies.currency_id')->
                        select('salaries.salary_id',
                            'companies.company_id',
                            'companies.name',
                            'companies.image',
                            'positions.position_id',
                            'positions.position',
                            'salaries.created_at',
                            'currencies.currency',
                            DB::raw("COUNT(*) as cnt,AVG(salary) as avg,MAX(salary) as max,MIN(salary) as min"))->
                        groupBy(['companies.company_id','positions.position_id'])->latest('salaries.created_at')->get();

        $jobs=Job::with(['position','position.company','currency'])->latest('jobs.created_at')->get();

        $feeds=$reviews->merge($salary)->merge($jobs)->sortByDesc('created_at');
        $feeds->each(function($f){
            if($f['avg'])
            {
                $f['isA']='salary';
            }
            else if($f['average_rating'])
            {
                $f['isA']='review';
            }
            else if($f['job_id'])
            {
                $f['isA']='jobs';
            }
        });
        $max_page=sizeof($feeds)/20;
        $feeds=$feeds->forPage(1,20);
        //$feeds=Company::with(['follow','salary','salary.review','salary.review.helpful','position','position.job','salary.currency'])->latest('salary.created_at')->paginate(20);
        return response()->json([
            'data'=>$feeds,
            'max_page'=>$max_page
        ]);

        $followedCompany=Company::with('follow')->where('company_id',22)->get();
        return response()->json([
            'fc'=>$followedCompany
        ]);
    }
}
