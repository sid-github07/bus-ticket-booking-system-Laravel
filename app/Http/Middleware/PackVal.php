<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\User;
use App\Product;
use Auth;

class PackVal
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
      if (Auth::check()) {
        $user = User::find(Auth::user()->id);
        if (!empty($user->expired_date)) {
          $today = new \Carbon\Carbon(Carbon::now());
          $existingVal = new \Carbon\Carbon($user->expired_date);
          if ($today->gt($existingVal)) {
            $user->ads = NULL;
            $user->feature = NULL;
            $user->expired_date = NULL;
            $user->save();

            $user->products()->update(['featured' => 0]);

          }
        }
      }

      return $next($request);
    }
}
