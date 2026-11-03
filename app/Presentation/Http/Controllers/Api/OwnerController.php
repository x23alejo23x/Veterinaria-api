<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\Owner\UseCases\CreateOwner;
use App\Application\Owner\UseCases\DeleteOwner;
use App\Application\Owner\UseCases\GetOwner;
use App\Application\Owner\UseCases\ListOwners;
use App\Application\Owner\UseCases\UpdateOwner;
use App\Domain\Owner\DTOs\OwnerDTO;
use App\Presentation\Http\Requests\Owner\StoreOwnerRequest;
use App\Presentation\Http\Requests\Owner\UpdateOwnerRequest;
use App\Presentation\Http\Resources\OwnerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class OwnerController
{
    public function __construct(
        private readonly ListOwners $listOwners,
        private readonly GetOwner $getOwner,
        private readonly CreateOwner $createOwner,
        private readonly UpdateOwner $updateOwner,
        private readonly DeleteOwner $deleteOwner,
    ) {}

    #[OA\Get(
        path: '/owners',
        summary: 'Listar propietarios',
        security: [['bearerAuth' => []]],
        tags: ['Owners'],
        parameters: [
            new OA\Parameter(name: 'page',     in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'search',   in: 'query', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lista paginada de propietarios'),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $result = $this->listOwners->execute(
            page: (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 20),
            search: $request->get('search'),
        );

        return response()->json([
            'data' => OwnerResource::collection(collect($result['items'])),
            'meta' => [
                'total'    => $result['total'],
                'page'     => $result['page'],
                'per_page' => $result['per_page'],
            ],
        ]);
    }

    #[OA\Get(
        path: '/owners/{id}',
        summary: 'Obtener propietario',
        security: [['bearerAuth' => []]],
        tags: ['Owners'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Propietario'),
            new OA\Response(response: 404, description: 'No encontrado'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $owner = $this->getOwner->execute($id);
        return response()->json(['data' => new OwnerResource($owner)]);
    }

    #[OA\Post(
        path: '/owners',
        summary: 'Crear propietario',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'phone'],
                properties: [
                    new OA\Property(property: 'name',    type: 'string', example: 'Juan Pérez'),
                    new OA\Property(property: 'email',   type: 'string', example: 'juan@example.com'),
                    new OA\Property(property: 'phone',   type: 'string', example: '3001234567'),
                    new OA\Property(property: 'address', type: 'string', example: 'Calle 10 #20-30'),
                ]
            )
        ),
        tags: ['Owners'],
        responses: [
            new OA\Response(response: 201, description: 'Propietario creado'),
        ]
    )]
    public function store(StoreOwnerRequest $request): JsonResponse
    {
        $owner = $this->createOwner->execute(OwnerDTO::fromArray($request->validated()));
        return response()->json(['data' => new OwnerResource($owner)], Response::HTTP_CREATED);
    }

    #[OA\Put(
        path: '/owners/{id}',
        summary: 'Actualizar propietario',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                ]
            )
        ),
        tags: ['Owners'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Propietario actualizado'),
        ]
    )]
    public function update(UpdateOwnerRequest $request, int $id): JsonResponse
    {
        $owner = $this->updateOwner->execute($id, OwnerDTO::fromArray($request->validated()));
        return response()->json(['data' => new OwnerResource($owner)]);
    }

    #[OA\Delete(
        path: '/owners/{id}',
        summary: 'Eliminar propietario',
        security: [['bearerAuth' => []]],
        tags: ['Owners'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Eliminado'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->deleteOwner->execute($id);
        return response()->json(['message' => 'Propietario eliminado correctamente.'], Response::HTTP_OK);
    }
}
