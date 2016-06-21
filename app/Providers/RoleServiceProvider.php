<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use View;

use DB;

use Auth;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('app', function($view){
            $user = \Auth::user();
            $info =  DB::table('users')
                ->where('id', '=', $user->id)
                ->get(); 
            foreach ($info as $result){
                $role = $result->role;
            }     
            $view->with('role', $role);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
