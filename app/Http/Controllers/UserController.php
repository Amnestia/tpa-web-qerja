<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class UserController extends Controller
{
    //
    public function doRegister(Request $req)
    {
        $rules=[
          'name'=>'required',
          'email'=>'required|email|unique:users',
          'password'=>'required|min:6|confirmed',
        ];
        $input=Input::only('name', 'email', 'password', 'password_confirmation');

        $validator=Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json([
               'errors'=>$validator->getMessageBag()->toArray(),
            ]);
        }
        $verification_code=str_random(47);

        Mail::send('verification_email',array('verification_code'=>$verification_code),function($message)
        {
            $message->to(Input::get('email'))->subject('Verify your email address');
        });

        $user = new User();
        $user->name=$req->name;
        $user->email=$req->email;
        $user->password=bcrypt($req->password);
        $user->verification_code=$verification_code;
        $user->save();

        return response()->json([
            'message'=>$user->name,
        ]);
    }

    public function doLogin(Request $req)
    {
        $rules=[
            'email'=>'required',
            'password'=>'required',
        ];
        $input=Input::only('email','password');

        $validator=Validator::make($input,$rules);
        if($validator->fails())
        {
            return response()->json([
                'errors'=>$validator->getMessageBag()->toArray(),
            ]);
        }
        if(Auth::attempt(['email'=>$req->email,'password'=>$req->password]))
        {
            if(!auth()->user()->verified)
            {
                $user=auth()->user();
                Auth::logout();
                return response()->json([
                    'failed'=>"You have not verified your account,",
                    'user'=>$user
                ]);
            }
            if($req->remember==1)
            {
                return response()->json([
                    'user'=>auth()->user()
                ])->withCookie(Cookie::make('user',auth()->user()->getRememberToken(),365.25*24*60));
            }
            return response()->json([
                'user'=>auth()->user()
            ]);
        }
        else
        {
            return response()->json([
                'failed'=>'Login failed.'
            ]);
        }
    }

    public function doVerify($confirmation_code)
    {
        $user=User::where('verification_code',$confirmation_code)->first();
        if($user)
        {
            $user->verification_code=null;
            $user->verified=1;
            $user->updated_at=Carbon::now()->toDateTimeString();
            $user->save();
            return redirect('/searchList/company');
        }
        else
        {
            return redirect('/');
        }
    }

    public function checkLogin()
    {
        if(Auth::check())
        {
            return response()->json([
                'user'=>auth()->user()
            ]);
        }
        return response()->json([
            'failed'=>''
        ]);
    }

    public function doLogout()
    {
        Auth::logout();
        if(Cookie::get("user"))
        return response()->json()->withCookie(Cookie::forget('user'));
        else
        return response()->json();
    }

    public function resendEmail(Request $req)
    {
        $verification_code=str_random(47);
        $input=Input::only('email');
        Mail::send('verification_email',array('verification_code'=>$verification_code),function($message)
        {
            $message->to(Input::get('email'))->subject('Verify your email address');
        });

        $user = User::find($req->id);
        $user->verification_code=$verification_code;
        $user->save();
        return response()->json([
            'success'=>''
        ]);
    }

    public function changeProfilePicture(Request $req)
    {
        $filename=$req->file('pict')->getClientOriginalName();
        $user=auth()->user();
        $user->profile_picture=$filename;
        $user->updated_at=Carbon::now()->toDateTimeString();
        $user->save();
        $req->file('pict')->move(public_path('/profile_picture/'),$filename);
        return response()->json([
            'user'=>$user
        ]);
    }

    public function changePassword(Request $req)
    {
        $user=User::find($req->id);
        $rules=[
          'oldPass'=>'required',
          'newPass'=>'required|min:6|different:oldPass',
          'conPass'=>'required|same:newPass'
        ];
        $validator=Validator::make($req->all(),$rules);
        if($validator->fails())
        {
            return response()->json([
                'errors'=>$validator->getMessageBag()->toArray(),
            ]);
        }
        else if(!Hash::check($req->oldPass,$user->password))
        {
            return response()->json([
                'errors'=>'Old password does not matched.',
                'user'=>$user,
                'id'=>$req->id
            ]);
        }
        $user->password=bcrypt($req->newPass);
        $user->updated_at=Carbon::now()->toDateTimeString();
        $user->save();
        return response()->json([
            'success'=>''
        ]);
    }

    public function getUserList()
    {
        $user=User::all();
        unset($user[0]);
        return response()->json([
           'users'=>$user
        ]);
    }
}
