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
use App\User1C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'email|unique:contragents',
            'id' => 'required|string|max:255|unique:contragents_1C',
            'password' => 'required|same:repeat_password|required_with:repeat_password',
            'repeat_password' => 'required',
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'success'=> false,
                'msg' => 'validation errors',
                'errors' => $validator->errors()
            ]);
        }

        $data = $request->all();

        $data['password'] = hash('sha256', $data['password']);

        User1C::create(array_merge($data, ['is_deleted' => 0]));

        return response()->json(['success' => true, 'msg' => 'success!']);
    }

    public function messages()
    {
        return [
            'name.required' => 'Необходимо заполнить Имя',
            'name.string' => 'Имя должно быть строкой',
            'email.email' => 'Неправильный формат Email',
            'email.unique' => 'Пользователь с таким Email уже существует',
            'password.required' => 'Необходимо заполнить пароль',
            'password.same' => 'Пароли должны совпадать',
            'repeat_password.required' => 'Необходимо повторить пароль',
            'id.unique' => 'ИИН/БИН уже занят',
            'amo_id.unique' => 'AMO ID уже занят',
            'full_name' => 'Необходимо заполнить Полное имя',
        ];
    }
}