<?php

namespace App\Http\Controllers;

use App\Company;
use App\Follow;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function checkFollow(Request $req)
    {
        $follow=Follow::where('company_id',$req->id)->where('user_id',$req->user_id)->whereNull('deleted_at')->first();
        if($follow)
        {
            return response()->json([
               'follow'=>true,
            ]);
        }
        return response()->json([
           'follow'=>false
        ]);
    }

    public function follow(Request $req)
    {
        $follow=Follow::where('company_id',$req->id)->where('user_id',$req->user_id)->first();
        if($follow)
        {
            $follow->created_at=Carbon::now()->toDateTimeString();
            $follow->updated_at=Carbon::now()->toDateTimeString();
            $follow->deleted_at=null;
            $follow->save();
            return response()->json([
                'success'=>''
            ]);
        }
        $follow=new Follow();
        $follow->company_id=$req->id;
        $follow->user_id=$req->user_id;
        $follow->created_at=Carbon::now()->toDateTimeString();
        $follow->updated_at=Carbon::now()->toDateTimeString();
        $follow->save();
        return response()->json([
            'success'=>''
        ]);
    }

    public function unfollow(Request $req)
    {
        $follow=Follow::where('company_id',$req->id)->where('user_id',$req->user_id)->first();
        if($follow)
        {
            $follow->deleted_at=Carbon::now()->toDateTimeString();
            $follow->save();
            return response()->json([
                'success'=>''
            ]);
        }
        else
        {
            return response()->json([
                'failed'=>''
            ]);
        }
    }
}
