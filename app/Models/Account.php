<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';
    public $timestamps = false;
    protected $fillable = ['username', 'email', 'password', 'avatar'];

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'unique:accounts,username'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'avatar' => ['mimes:jpeg,png']
        ]);

        if($request->file('avatar')){
            $avatar = basename($request->file('avatar')->storeAs('avatars/', $request->username.'-avatar.'.$request->file('avatar')->extension()));
            unlink($request->file('avatar')->getRealPath());
        }
        else{
            $avatar = 'base-avatar.jpg';
        }

        try{
            Account::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => $avatar
            ]);

            session(['user'=> $request->username]);
            return response()->json(['message' => 'OK'], 200);
        }
        catch(\Exception $e){
            if($avatar != 'base-avatar.jpg'){
                unlink($request->file('avatar')->path());
            }
            return response()->json(['message' => 'Something went wrong:'. $e->getMessage()], 422);
        }
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $userdata = Account::where('username', $request->username)->first();
        if(!$userdata){
            return response()->json(['message' => 'Wrong username or password'], 422);
        }
        else{
            if(Hash::check($request->password, $userdata->password)){
                session(['user'=> $request->username]);
                return response()->json(['message' => 'OK'], 200);
            } 
            else{
                return response()->json(['message' => 'Wrong username or password'], 422);
            }
        }
    }

    public function logOut()
    {
        if(session()->has('user')){
            session()->forget('user');
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
