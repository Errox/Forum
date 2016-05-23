<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();

        $user = User::find($user->id);

        $role = $user->role;

        if($role == 0){
            return redirect('/topic');
        }
        else{
            return $next($request);
        }
    }
}
