<?php

namespace App\Http\Controllers;

use App\Helpful;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function getReview(Request $req)
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
                                         'reviews.review_id',
                                         'reviews.salary_rate',
                                         'reviews.career_rate',
                                         'reviews.balance_rate',
                                         'reviews.culture_rate',
                                         'reviews.management_rate')->
                        groupBy(['companies.company_id','positions.position_id'])->latest('reviews.created_at')->paginate(20);
        $reviews->each(function($r){
           $r['avg']=($r['salary_rate']+$r['balance_rate']+$r['career_rate']+$r['culture_rate']+$r['management_rate'])/5;
        });
        return response()->json([
            'reviews'=>$reviews
        ]);
    }

    public function getReviewForCompany(Request $req)
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
                            'reviews.management_rate')->
                        groupBy(['companies.company_id','positions.position_id'])->where('companies.company_id',$req->id)
                        ->latest('reviews.created_at')->paginate(10);
        $reviews->each(function($r){
            $r['avg']=($r['salary_rate']+$r['balance_rate']+$r['career_rate']+$r['culture_rate']+$r['management_rate'])/5;
            $help=Helpful::where('review_id',$r['review_id'])->where('user_id',\request()->user_id)->whereNull('deleted_at')->first();
            $count=Helpful::where('review_id',$r['review_id'])->whereNull('deleted_at')->groupBy('review_id')->count();
            if($help)
            {
                $r['helpful']=true;
            }
            else
            {
                $r['helpful']=false;
            }
            $r['count']=$count;
        });
        return response()->json([
            'data'=>$reviews
        ]);
    }
}
