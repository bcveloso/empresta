<?php

namespace App\Http\Middleware;

use Closure;
use PhpParser\Node\Stmt\TryCatch;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class apiProtectedRoute extends BaseMiddleware
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
        try{
            $user = JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'token invalido']);
            }elseif($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'token expirou']);
            }else{
                return response()->json(['status' => 'token não autorizado']);
            }
        }
        return $next($request);
    }
}
