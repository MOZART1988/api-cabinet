<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 21.01.19
 * Time: 14:36
 */

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|same:repeat_password|required_with:repeat_password',
            'repeat_password' => 'required'
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success'=> false,
                'msg' => 'validation errors',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $token = \JWTAuth::fromUser($user);

        return response()->json(['success' => true, 'msg' => 'success!', 'token' => $token]);
    }

    public function messages()
    {
        return [
            'name.required' => 'Необходимо заполнить Имя',
            'name.string' => 'Имя должно быть строкой',
            'email.required' => 'Необходимо заполнить Email',
            'email.email' => 'Неправильный формат Email',
            'email.unique' => 'Пользователь с таким Email уже существует',
            'password.required' => 'Необходимо заполнить пароль',
            'password.same' => 'Пароли должны совпадать',
            'repeat_password.required' => 'Необходимо повторить пароль'
        ];
    }
}