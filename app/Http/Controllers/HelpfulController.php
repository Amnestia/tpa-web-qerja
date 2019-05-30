<?php

namespace App\Http\Controllers;

use App\Helpful;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HelpfulController extends Controller
{
    //
    public function helpful(Request $req)
    {
        $helpful=Helpful::where('review_id',$req->id)->where('user_id',$req->user_id)->first();
        if($helpful)
        {
            $helpful->created_at=Carbon::now()->toDateTimeString();
            $helpful->updated_at=Carbon::now()->toDateTimeString();
            $helpful->deleted_at=null;
            $helpful->save();
            return response()->json([
                'success'=>''
            ]);
        }
        $helpful=new Helpful();
        $helpful->review_id=$req->id;
        $helpful->user_id=$req->user_id;
        $helpful->created_at=Carbon::now()->toDateTimeString();
        $helpful->updated_at=Carbon::now()->toDateTimeString();
        $helpful->save();
        return response()->json([
            'success'=>''
        ]);
    }

    public function delHelpful(Request $req)
    {
        $helpful=Helpful::where('review_id',$req->id)->where('user_id',$req->user_id)->first();
        if($helpful)
        {
            $helpful->deleted_at=Carbon::now()->toDateTimeString();
            $helpful->save();
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
