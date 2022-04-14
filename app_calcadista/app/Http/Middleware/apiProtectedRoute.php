<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!\JWTAuth::getToken()) {
            return response()->json(['status' => 401, 'error' => 'token ausente'], 200);
        } else {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            }catch (\Exception $e){
                if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['status' => 401, 'error' => 'token inválido'], 200);
                }else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['status' => 401, 'error' => 'token expirou'], 200);
                }else{
                    return  response()->json(['status' => 'Token de autorização não encontrado']);
                }
            }
        }
        return $next($request);
    }
}
