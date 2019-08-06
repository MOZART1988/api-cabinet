<?php

namespace App\Http\Controllers\Api\Auth;

use App\Mail\RecoverMail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class RecoverController extends Controller
{
    public function send(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|string|max:255|email',
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success'=> false,
                'msg' => 'Пожалуйста заполните email',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::where('email', '=', $request['email'])->first();

        if ($user === null) {
            return response()->json([
                'success'=> false,
                'msg' => 'Пользователь с таким email не найден',
                'errors' => ['email' => ['Пользователь с таким email не найден']]
            ]);
        }

        $user->recover_token = Str::random(20);
        $user->save();

        \Mail::to($request['email'])->send(new RecoverMail($user));

        return response()->json(['success' => true, 'msg' => 'success!']);
    }

    public function recover(string $token)
    {
        $user = User::where('recover_token', '=', $token)->first();

        if ($user === null) {
            return response()->json([
                'success'=> false,
                'msg' => 'Пользователя не существует',
                'errors' => ['email' => ['Пользователь с таким email не найден']]
            ]);
        }

        return response()->json(['success' => true, 'msg' => 'Пользователь найден', 'recoverToken' => $token]);
    }

    public function changePassword(Request $request, string $token)
    {
        $user = User::where('recover_token', '=', $token)->first();

        if ($user === null) {
            return response()->json([
                'success'=> false,
                'msg' => 'Пользователя не существует',
                'errors' => []
            ]);
        }

        $validator = \Validator::make($request->post(), [
            'password' => 'required|required_with:repeat_password|same:repeat_password',
            'repeat_password' => 'required'
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success'=> false,
                'msg' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ]);
        }

        $user->recover_token = null;
        $user->password = bcrypt($request['password']);
        $user->save();

        $authToken = \JWTAuth::fromUser($user);

        return response()->json(['success' => true, 'msg' => 'success!', 'token' => $authToken]);
    }

    public function messages()
    {
        return [
            'email.required' => 'Необходимо заполнить Email',
            'email.email' => 'Неправильный формат Email',
            'email.unique' => 'Пользователь с таким Email уже существует',
            'password.required' => 'Необходимо заполнить пароль',
            'password.same' => 'Пароли должны совпадать',
            'repeat_password.required' => 'Необходимо повторить пароль'
        ];
    }
}
