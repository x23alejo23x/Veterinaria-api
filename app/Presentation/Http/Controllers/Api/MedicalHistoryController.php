<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\MedicalHistory\UseCases\CreateMedicalHistory;
use App\Application\MedicalHistory\UseCases\DeleteMedicalHistory;
use App\Application\MedicalHistory\UseCases\GetMedicalHistory;
use App\Application\MedicalHistory\UseCases\ListMedicalHistories;
use App\Application\MedicalHistory\UseCases\UpdateMedicalHistory;
use App\Domain\MedicalHistory\DTOs\MedicalHistoryDTO;
use App\Presentation\Http\Requests\MedicalHistory\StoreMedicalHistoryRequest;
use App\Presentation\Http\Requests\MedicalHistory\UpdateMedicalHistoryRequest;
use App\Presentation\Http\Resources\MedicalHistoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class MedicalHistoryController
{
    public function __construct(
        private readonly ListMedicalHistories $listMedicalHistories,
        private readonly GetMedicalHistory $getMedicalHistory,
        private readonly CreateMedicalHistory $createMedicalHistory,
        private readonly UpdateMedicalHistory $updateMedicalHistory,
        private readonly DeleteMedicalHistory $deleteMedicalHistory,
    ) {}

    #[OA\Get(
        path: '/medical-history',
        summary: 'Listar historiales médicos',
        security: [['bearerAuth' => []]],
        tags: ['MedicalHistory'],
        parameters: [
            new OA\Parameter(name: 'page',     in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lista paginada de historiales médicos'),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $result = $this->listMedicalHistories->execute(
            page: (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 20),
        );

        return response()->json([
            'data' => MedicalHistoryResource::collection(collect($result['items'])),
            'meta' => [
                'total'    => $result['total'],
                'page'     => $result['page'],
                'per_page' => $result['per_page'],
            ],
        ]);
    }

    #[OA\Get(
        path: '/medical-history/{id}',
        summary: 'Obtener historial médico',
        security: [['bearerAuth' => []]],
        tags: ['MedicalHistory'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Historial médico'),
            new OA\Response(response: 404, description: 'No encontrado'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $record = $this->getMedicalHistory->execute($id);
        return response()->json(['data' => new MedicalHistoryResource($record)]);
    }

    #[OA\Post(
        path: '/medical-history',
        summary: 'Crear historial médico',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['patient_id', 'diagnosis', 'date'],
                properties: [
                    new OA\Property(property: 'patient_id', type: 'integer', example: 1),
                    new OA\Property(property: 'diagnosis',  type: 'string',  example: 'Gastritis leve'),
                    new OA\Property(property: 'treatment',  type: 'string',  example: 'Dieta blanda y omeprazol'),
                    new OA\Property(property: 'date',       type: 'string',  format: 'date', example: '2025-06-01'),
                    new OA\Property(property: 'notes',      type: 'string',  example: 'Seguimiento en 15 días'),
                ]
            )
        ),
        tags: ['MedicalHistory'],
        responses: [
            new OA\Response(response: 201, description: 'Historial médico creado'),
        ]
    )]
    public function store(StoreMedicalHistoryRequest $request): JsonResponse
    {
        $record = $this->createMedicalHistory->execute(MedicalHistoryDTO::fromArray($request->validated()));
        return response()->json(['data' => new MedicalHistoryResource($record)], Response::HTTP_CREATED);
    }

    #[OA\Put(
        path: '/medical-history/{id}',
        summary: 'Actualizar historial médico',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'diagnosis', type: 'string'),
                ]
            )
        ),
        tags: ['MedicalHistory'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Historial médico actualizado'),
        ]
    )]
    public function update(UpdateMedicalHistoryRequest $request, int $id): JsonResponse
    {
        $record = $this->updateMedicalHistory->execute($id, MedicalHistoryDTO::fromArray($request->validated()));
        return response()->json(['data' => new MedicalHistoryResource($record)]);
    }

    #[OA\Delete(
        path: '/medical-history/{id}',
        summary: 'Eliminar historial médico',
        security: [['bearerAuth' => []]],
        tags: ['MedicalHistory'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Eliminado'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->deleteMedicalHistory->execute($id);
        return response()->json(['message' => 'Registro eliminado correctamente.'], Response::HTTP_OK);
    }
}
