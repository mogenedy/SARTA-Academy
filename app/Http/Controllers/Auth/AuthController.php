<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);
        
        if ($request->hasFile('image')) { 
            $user->addMediaFromRequest('image')->toMediaCollection("main");
        }

        $user->assignRole('client');
        
        return $this->respondCreated(UserResource::make($user), __("auth.Registered successfully"));

    }


    public function login(LoginUserRequest $request)
    {
        $fields = $request->validated();

        $user = User::where('email', $fields['email'])->first();

        if (! $user || ! Hash::check(request()->post('password'), $user->password)) {
            return $this->respondError('Bad credentials.');
        }

        $token = $user->createToken(env("SANCTUM_TOKEN"))->plainTextToken;

        $user->token = $token;
        $user->role = $user->getRoleNames()[0];

        if($user->role == "researcher"){
            $user->load('researcher_profile');
        }
        
        unset($user->roles);
        
        return $this->respondOk([
            "user" => UserResource::make($user)
        ] , __("auth.Login successfully"));

    }

    public function logout(Request $request){
        
        $request->user->currentAccessToken()->delete();
        return $this->respondNoContent();
    }

    public function logoutAllDevices(Request $request){
        
        $request->user->tokens()->delete();
        return $this->respondNoContent();
    }

}
    
