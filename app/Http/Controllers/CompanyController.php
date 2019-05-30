<?php

namespace App\Http\Controllers;

use App\Company;
use App\Follow;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //
    public function getAll(Request $req)
    {
        $companies=Company::paginate(20);
        $size=sizeof($companies);
        for($i=0 ; $i<$size;++$i)
        {
            $follow=Follow::where('company_id',$companies[$i]['company_id'])->where('user_id',$req['user_id'])->whereNull('deleted_at')->first();
            if($follow)
            {
                $companies[$i]['followed']=true;
                $companies[$i]['follow']=$follow;
            }
            else
            {
                $companies[$i]['followed']=false;
                $companies[$i]['follow']=$follow;
            }
        }
        return response()->json([
           'companies'=>$companies,
            'user_id'=>$req['user_id']
        ]);
    }

    public function getDetail(Request $req)
    {
        $company = Company::find($req->id);
        return response()->json([
            'company'=>$company,
            'country'=>$company->country->country_name,
            'city'=>$company->city->city_name,
            'category'=>$company->category->category
        ]);
    }
}
