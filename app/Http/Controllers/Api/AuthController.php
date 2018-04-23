<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\User;


class AuthController extends Controller
{
    public function login(Request $request)
    {
      $user = User::where('email', $request->email)->first();
      $login = $request->login;

      if(!$user) {
          return [
            'error' => 'Неверный email!',
          ];
      }

      if($user->password != md5($request->password)) {
          return [
            'error' => 'Неверный пароль!',
          ];
      }

      $token = md5($request->email.$request->password.$request->name.str_random(8));

      $user->token = $token;

      $user->save();

      return [
        'token' => $token,
      ];
    }

    public function userUpdate(Request $request)
    {
        $authRequest = $request->header('Authorization');
        $user = User::where('token', $authRequest)->first();


        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = md5($request->password);

        $user->save();

        return $user;

    }

    public function GetUserInfo(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->get();
        if($user)
          return $user;
        else return [
          'error' => 'Пожалуйста, войдите в аккаунт'
        ];
    }

}
