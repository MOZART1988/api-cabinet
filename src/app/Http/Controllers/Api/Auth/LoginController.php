<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:255',
            'password' => 'required'
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(
                [
                    'success'=> false,
                    'msg' => 'validation errors',
                    'errors' => $validator->errors()
                ]
            );
        }

        $credentials = $request->only('id', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'validation_errors',
                    'errors' => ['password' => ['Неправильный логин/пароль']]
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'internal error',
                'errors' => ['email' => ['Невозможно создать токен']]
                ], 500);
        }

        return response()->json(['success' => true, 'msg' => 'success!', 'token' => $token]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response()->json([
            'status' => 'Success',
            'msg' => 'Logged out Successfully'
        ]);
    }

    public function messages()
    {
        return [
            'id.required' => 'Необходимо заполнить БИН',
            'password.required' => 'Необходимо заполнить пароль'
        ];
    }
}