<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $userOptions = $request->all();

        if($userOptions) {

          if(!$user) {

            $userOptions['password'] = md5($userOptions['password']);
            $user = User::create($userOptions);
            return $user;

          }
          else return [
            'error' => 'Email has already existed'
          ];
        }

        return [
          'error' => 'No data!',
        ];
    }
}
