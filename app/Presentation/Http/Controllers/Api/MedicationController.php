<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\Medication\UseCases\CreateMedication;
use App\Application\Medication\UseCases\DeleteMedication;
use App\Application\Medication\UseCases\GetMedication;
use App\Application\Medication\UseCases\ListMedications;
use App\Application\Medication\UseCases\UpdateMedication;
use App\Domain\Medication\DTOs\MedicationDTO;
use App\Presentation\Http\Requests\Medication\StoreMedicationRequest;
use App\Presentation\Http\Requests\Medication\UpdateMedicationRequest;
use App\Presentation\Http\Resources\MedicationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class MedicationController
{
    public function __construct(
        private readonly ListMedications $listMedications,
        private readonly GetMedication $getMedication,
        private readonly CreateMedication $createMedication,
        private readonly UpdateMedication $updateMedication,
        private readonly DeleteMedication $deleteMedication,
    ) {}

    #[OA\Get(
        path: '/medications',
        summary: 'Listar medicamentos',
        security: [['bearerAuth' => []]],
        tags: ['Medications'],
        parameters: [
            new OA\Parameter(name: 'page',     in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'search',   in: 'query', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lista paginada de medicamentos'),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $result = $this->listMedications->execute(
            page: (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 20),
            search: $request->get('search'),
        );

        return response()->json([
            'data' => MedicationResource::collection(collect($result['items'])),
            'meta' => [
                'total'    => $result['total'],
                'page'     => $result['page'],
                'per_page' => $result['per_page'],
            ],
        ]);
    }

    #[OA\Get(
        path: '/medications/{id}',
        summary: 'Obtener medicamento',
        security: [['bearerAuth' => []]],
        tags: ['Medications'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Medicamento'),
            new OA\Response(response: 404, description: 'No encontrado'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $medication = $this->getMedication->execute($id);
        return response()->json(['data' => new MedicationResource($medication)]);
    }

    #[OA\Post(
        path: '/medications',
        summary: 'Crear medicamento',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'unit'],
                properties: [
                    new OA\Property(property: 'name',        type: 'string',  example: 'Amoxicilina'),
                    new OA\Property(property: 'description', type: 'string',  example: 'Antibiótico de amplio espectro'),
                    new OA\Property(property: 'unit',        type: 'string',  example: 'mg'),
                    new OA\Property(property: 'stock',       type: 'integer', example: 100),
                ]
            )
        ),
        tags: ['Medications'],
        responses: [
            new OA\Response(response: 201, description: 'Medicamento creado'),
        ]
    )]
    public function store(StoreMedicationRequest $request): JsonResponse
    {
        $medication = $this->createMedication->execute(MedicationDTO::fromArray($request->validated()));
        return response()->json(['data' => new MedicationResource($medication)], Response::HTTP_CREATED);
    }

    #[OA\Put(
        path: '/medications/{id}',
        summary: 'Actualizar medicamento',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                ]
            )
        ),
        tags: ['Medications'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Medicamento actualizado'),
        ]
    )]
    public function update(UpdateMedicationRequest $request, int $id): JsonResponse
    {
        $medication = $this->updateMedication->execute($id, MedicationDTO::fromArray($request->validated()));
        return response()->json(['data' => new MedicationResource($medication)]);
    }

    #[OA\Delete(
        path: '/medications/{id}',
        summary: 'Eliminar medicamento',
        security: [['bearerAuth' => []]],
        tags: ['Medications'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Eliminado'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->deleteMedication->execute($id);
        return response()->json(['message' => 'Medicación eliminada correctamente.'], Response::HTTP_OK);
    }
}
