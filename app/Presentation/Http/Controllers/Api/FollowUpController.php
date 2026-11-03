<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\FollowUp\UseCases\CreateFollowUp;
use App\Application\FollowUp\UseCases\DeleteFollowUp;
use App\Application\FollowUp\UseCases\GetFollowUp;
use App\Application\FollowUp\UseCases\ListFollowUps;
use App\Application\FollowUp\UseCases\UpdateFollowUp;
use App\Domain\FollowUp\DTOs\FollowUpDTO;
use App\Presentation\Http\Requests\FollowUp\StoreFollowUpRequest;
use App\Presentation\Http\Requests\FollowUp\UpdateFollowUpRequest;
use App\Presentation\Http\Resources\FollowUpResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class FollowUpController
{
    public function __construct(
        private readonly ListFollowUps $listFollowUps,
        private readonly GetFollowUp $getFollowUp,
        private readonly CreateFollowUp $createFollowUp,
        private readonly UpdateFollowUp $updateFollowUp,
        private readonly DeleteFollowUp $deleteFollowUp,
    ) {}

    #[OA\Get(
        path: '/follow-ups',
        summary: 'Listar seguimientos',
        security: [['bearerAuth' => []]],
        tags: ['FollowUps'],
        parameters: [
            new OA\Parameter(name: 'page',     in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'status',   in: 'query', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lista paginada de seguimientos'),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $result = $this->listFollowUps->execute(
            page: (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 20),
            status: $request->get('status'),
        );

        return response()->json([
            'data' => FollowUpResource::collection(collect($result['items'])),
            'meta' => [
                'total'    => $result['total'],
                'page'     => $result['page'],
                'per_page' => $result['per_page'],
            ],
        ]);
    }

    #[OA\Get(
        path: '/follow-ups/{id}',
        summary: 'Obtener seguimiento',
        security: [['bearerAuth' => []]],
        tags: ['FollowUps'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Seguimiento'),
            new OA\Response(response: 404, description: 'No encontrado'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $followUp = $this->getFollowUp->execute($id);
        return response()->json(['data' => new FollowUpResource($followUp)]);
    }

    #[OA\Post(
        path: '/follow-ups',
        summary: 'Crear seguimiento',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['patient_id', 'scheduled_at', 'notes'],
                properties: [
                    new OA\Property(property: 'patient_id',   type: 'integer', example: 1),
                    new OA\Property(property: 'scheduled_at', type: 'string',  format: 'date-time', example: '2025-06-15T10:00:00'),
                    new OA\Property(property: 'notes',        type: 'string',  example: 'Revisión post-tratamiento'),
                    new OA\Property(property: 'status',       type: 'string',  example: 'pending'),
                ]
            )
        ),
        tags: ['FollowUps'],
        responses: [
            new OA\Response(response: 201, description: 'Seguimiento creado'),
        ]
    )]
    public function store(StoreFollowUpRequest $request): JsonResponse
    {
        $followUp = $this->createFollowUp->execute(FollowUpDTO::fromArray($request->validated()));
        return response()->json(['data' => new FollowUpResource($followUp)], Response::HTTP_CREATED);
    }

    #[OA\Put(
        path: '/follow-ups/{id}',
        summary: 'Actualizar seguimiento',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string'),
                ]
            )
        ),
        tags: ['FollowUps'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Seguimiento actualizado'),
        ]
    )]
    public function update(UpdateFollowUpRequest $request, int $id): JsonResponse
    {
        $followUp = $this->updateFollowUp->execute($id, FollowUpDTO::fromArray($request->validated()));
        return response()->json(['data' => new FollowUpResource($followUp)]);
    }

    #[OA\Delete(
        path: '/follow-ups/{id}',
        summary: 'Eliminar seguimiento',
        security: [['bearerAuth' => []]],
        tags: ['FollowUps'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Eliminado'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->deleteFollowUp->execute($id);
        return response()->json(['message' => 'Seguimiento eliminado correctamente.'], Response::HTTP_OK);
    }
}
