<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

   view()->composer('layouts.header', function ($view) {
    $messagecount =0;
    if(auth::check())
        {
            $messagecount=Message::where("sender_id","!=",auth::id())->where("receiver_id",auth::id())
            ->where("is_read",false)
            ->where("delete_for_everyone",false)
            ->count();

        }
        $view->with("messagecount",$messagecount);
   });

    }
}
