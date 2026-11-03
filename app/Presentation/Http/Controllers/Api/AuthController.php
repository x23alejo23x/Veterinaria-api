<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\Auth\UseCases\LoginUser;
use App\Presentation\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class AuthController
{
    public function __construct(
        private readonly LoginUser $loginUser,
    ) {}

    #[OA\Post(
        path: '/auth/login',
        summary: 'Iniciar sesión',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email',    type: 'string', example: 'admin@nuravetcare.com'),
                    new OA\Property(property: 'password', type: 'string', example: 'password'),
                ]
            )
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Token Sanctum',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'token', type: 'string'),
                                new OA\Property(property: 'user',  type: 'object'),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Credenciales inválidas'),
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->loginUser->execute(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );

        return response()->json(['data' => $result], Response::HTTP_OK);
    }

    #[OA\Post(
        path: '/auth/logout',
        summary: 'Cerrar sesión',
        security: [['bearerAuth' => []]],
        tags: ['Auth'],
        responses: [
            new OA\Response(response: 200, description: 'Sesión cerrada'),
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente.'], Response::HTTP_OK);
    }

    #[OA\Get(
        path: '/auth/me',
        summary: 'Usuario autenticado',
        security: [['bearerAuth' => []]],
        tags: ['Auth'],
        responses: [
            new OA\Response(response: 200, description: 'Datos del usuario'),
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'data' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
        ]);
    }
}
