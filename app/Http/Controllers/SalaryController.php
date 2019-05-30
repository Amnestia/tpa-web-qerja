<?php

namespace App\Http\Controllers;

use App\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    //
    public function getSalaryForCompany(Request $req)
    {
        $salary=Salary::join('positions','salaries.position_id','positions.position_id')->
                        join('companies','salaries.company_id','companies.company_id')->
                        join('currencies','salaries.currency_id','currencies.currency_id')->
                        select('salaries.salary_id',
                            'companies.company_id',
                            'companies.name',
                            'companies.image',
                            'positions.position_id',
                            'positions.position',
                            'currencies.currency',
                            DB::raw("COUNT(*) as cnt,AVG(salary) as avg,MAX(salary) as max,MIN(salary) as min"))->
                        groupBy(['companies.company_id','positions.position_id'])->where('companies.company_id',$req->id)
                        ->latest('salaries.created_at')->paginate(10);
        return response()->json([
            'data'=>$salary,
            'req'=>$req
        ]);
    }

    public function getSalary(Request $req)
    {
        $salary=Salary::join('positions','salaries.position_id','positions.position_id')->
                        join('companies','salaries.company_id','companies.company_id')->
                        join('currencies','salaries.currency_id','currencies.currency_id')->
                        select('salaries.salary_id',
                                        'companies.company_id',
                                        'companies.name',
                                        'companies.image',
                                        'positions.position_id',
                                        'positions.position',
                                        'currencies.currency',
                            DB::raw("COUNT(*) as cnt,AVG(salary) as avg,MAX(salary) as max,MIN(salary) as min"))->
                        groupBy(['companies.company_id','positions.position_id'])->latest('salaries.created_at')->paginate(20);
        return response()->json([
            'salaries'=>$salary
        ]);
    }

}
