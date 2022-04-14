<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * Obtenha um token JWT por credenciais fornecidas.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $input = $request->validated();

        $credentials = [
            'email'    => $input['email'],
            'password' => $input['password'],
        ];

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        return $this->respondWithToken($token);
    }
    /**
     * Desconectar o usuário (invalidar o token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return response()->json(['mensagem' => 'Desconectado com sucesso']);
    }
    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
