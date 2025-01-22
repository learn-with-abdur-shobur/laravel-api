<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    // sign up
    public function signup( Request $request ) {

        // check valid
        $validUser = Validator::make(
            $request->all(),
            [
                'name'     => 'required',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required',
            ]
        );

        // if failed
        if ( $validUser->fails() ) {
            return response()->json( [
                'status'  => false,
                'message' => 'validator error',
                'errors'  => $validUser->errors()->all(),
            ], 401 );
        }

        // create user
        $user = User::create( [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
        ] );

        // return success
        return response()->json( [
            'status'  => true,
            'message' => 'User Create Success',
            'errors'  => $user,
        ], 200 );

    }

    //login
    public function login( Request $request ) {
        // check valid
        $validUser = Validator::make(
            $request->all(),
            [
                'email'    => 'required|email',
                'password' => 'required',
            ]
        );

        // if failed
        if ( $validUser->fails() ) {
            return response()->json( [
                'status'  => false,
                'message' => 'Auth Failed',
                'errors'  => $validUser->errors()->all(),
            ], 404 );
        }

        // if auth
        if ( Auth::attempt( ['email' => $request->email, 'password' => $request->password] ) ) {
            // return success
            $authUser = Auth::user();
            return response()->json( [
                'status'     => true,
                'message'    => 'User Create Success',
                'errors'     => "user",
                "token"      => $authUser->createToken( 'API Token' )->plainTextToken,
                'token_type' => 'bearer',
            ], 200 );
        } else {
            return response()->json( [
                'status'  => false,
                'message' => 'Auth Failed',
            ], 401 );
        }
    }

    // logout
    public function logout( Request $request ) {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json( [
            'status'  => true,
            'user'    => $user,
            'message' => "logout success",
        ], 200 );
    }
}
