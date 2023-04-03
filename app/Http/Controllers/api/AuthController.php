<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Requests\RegisterFormRequest;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * register an account.
     * 
     * @return Illuminate\Http\Response
     */
    public function register(RegisterFormRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        
        return $this->sendResponse($user, 'user created successfully!', Status::CREATED);
    }

    /**
     * register an account.
     * 
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $sucess['name'] = $user->name;

            return $this->sendResponse($success, 'user login successfully.');
        } else {
            return $this->sendError('Unauthorized', ['error' => 'Unauthorized'], Status::BAD_REQUEST);
        }
    }

    /**
     * register an account.
     * 
     * @return Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if (Auth::check())
        {
            $request->user()->token()->revoke();
            return $this->sendResponse([], 'successfully logged out.');
        } else {
            return $this->sendError('Unauthorized', ['error' => 'Unauthorized'], Status::BAD_REQUEST);
        }
    }
}
