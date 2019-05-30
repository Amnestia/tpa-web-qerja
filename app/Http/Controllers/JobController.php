<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    //
    public function getJobs(Request $req)
    {
        $jobs=Job::with(['position','position.company','currency'])->latest('jobs.created_at')->paginate(20);
        return response()->json([
            'jobs'=>$jobs
        ]);
    }

    public function getJobsForCompany(Request $req)
    {
        $jobs=Job::with(['position','position.company','currency'])->whereHas('position',function($p){
            $p->where('company_id',\request()->id);
        })->latest('jobs.created_at')->paginate(20);
        return response()->json([
            'data'=>$jobs
        ]);
    }
}
