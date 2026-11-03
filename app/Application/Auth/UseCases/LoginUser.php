<?php

declare(strict_types=1);

namespace App\Application\Auth\UseCases;

use App\Infrastructure\Persistence\Eloquent\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class LoginUser
{
    public function execute(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new HttpResponseException(
                response()->json(['message' => 'Credenciales incorrectas.'], Response::HTTP_UNAUTHORIZED)
            );
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user'  => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role],
            'token' => $token,
        ];
    }
}
