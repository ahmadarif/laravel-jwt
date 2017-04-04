<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class AuthenticateController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['postLogin']]);
    }

    public function postLogin(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return $this->responseValidation($e);
        }

        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        // Data User
        $user =  User::where('email', $request->input('email'))->first();

        // verify credential and generate token
        try {
            // custom claim
            $customClaims = ['user' => $user];

            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials, $customClaims)) {
                return response()->json([
                    'error' => 'invalid_credentials'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Could not create token',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

    public function patchRefreshToken()
    {
        $token = JWTAuth::parseToken()->refresh();
        return response()->json(compact('token'));
    }

    public function deleteInvalidate()
    {
        JWTAuth::parseToken()->invalidate();
        return response(['message' => 'Token invalidated']);
    }

    public function getProfil() {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json($user);
    }

}