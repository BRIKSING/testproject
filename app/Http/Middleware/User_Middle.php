<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class User_Middle
{
  // TODO: Поправить, если пользователь неудачно залогинился
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authRequest = $request->header('Authorization');
        $authUser = User::where('token', $authRequest)->first();
        $errors = [];

        if(!$authUser) {
          return redirect('welcome')->with(['error' => ['error' => "Такого пользователя не существует!"]]);
        }

        $errors = $this->checkErrors([
          'email' => $request->email,
          'name' => $request->name,
          'password' => $request->password
        ]);

        if(count($errors) > 0) {
          return redirect('welcome')->with(['error' => $errors]);
        }

        return $next($request);
    }

    public function checkErrors($values)
    {
        $errs = [];
        foreach ($values as $key => $value) {
          if(!($value))
            $errs[$key] = "Поле ${key} не заполнено!";
        }
        return $errs;
    }
}
