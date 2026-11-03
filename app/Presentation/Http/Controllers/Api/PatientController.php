<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\Patient\UseCases\CreatePatient;
use App\Application\Patient\UseCases\DeletePatient;
use App\Application\Patient\UseCases\GetPatient;
use App\Application\Patient\UseCases\ListPatients;
use App\Application\Patient\UseCases\UpdatePatient;
use App\Domain\Patient\DTOs\PatientDTO;
use App\Presentation\Http\Requests\Patient\StorePatientRequest;
use App\Presentation\Http\Requests\Patient\UpdatePatientRequest;
use App\Presentation\Http\Resources\PatientResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class PatientController
{
    public function __construct(
        private readonly ListPatients $listPatients,
        private readonly GetPatient $getPatient,
        private readonly CreatePatient $createPatient,
        private readonly UpdatePatient $updatePatient,
        private readonly DeletePatient $deletePatient,
    ) {}

    #[OA\Get(
        path: '/patients',
        summary: 'Listar pacientes',
        security: [['bearerAuth' => []]],
        tags: ['Patients'],
        parameters: [
            new OA\Parameter(name: 'page',     in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'search',   in: 'query', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lista paginada de pacientes'),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $result = $this->listPatients->execute(
            page: (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 20),
            search: $request->get('search'),
        );

        return response()->json([
            'data'  => PatientResource::collection(collect($result['items'])),
            'meta'  => [
                'total'    => $result['total'],
                'page'     => $result['page'],
                'per_page' => $result['per_page'],
            ],
        ]);
    }

    #[OA\Get(
        path: '/patients/{id}',
        summary: 'Obtener paciente',
        security: [['bearerAuth' => []]],
        tags: ['Patients'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paciente'),
            new OA\Response(response: 404, description: 'No encontrado'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $patient = $this->getPatient->execute($id);
        return response()->json(['data' => new PatientResource($patient)]);
    }

    #[OA\Post(
        path: '/patients',
        summary: 'Crear paciente',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'species', 'owner_id'],
                properties: [
                    new OA\Property(property: 'name',     type: 'string',  example: 'Rocky'),
                    new OA\Property(property: 'species',  type: 'string',  example: 'Canino'),
                    new OA\Property(property: 'breed',    type: 'string',  example: 'Labrador'),
                    new OA\Property(property: 'age',      type: 'integer', example: 3),
                    new OA\Property(property: 'weight',   type: 'number',  example: 25.5),
                    new OA\Property(property: 'owner_id', type: 'integer', example: 1),
                ]
            )
        ),
        tags: ['Patients'],
        responses: [
            new OA\Response(response: 201, description: 'Paciente creado'),
        ]
    )]
    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = $this->createPatient->execute(PatientDTO::fromArray($request->validated()));
        return response()->json(['data' => new PatientResource($patient)], Response::HTTP_CREATED);
    }

    #[OA\Put(
        path: '/patients/{id}',
        summary: 'Actualizar paciente',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                ]
            )
        ),
        tags: ['Patients'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paciente actualizado'),
        ]
    )]
    public function update(UpdatePatientRequest $request, int $id): JsonResponse
    {
        $patient = $this->updatePatient->execute($id, PatientDTO::fromArray($request->validated()));
        return response()->json(['data' => new PatientResource($patient)]);
    }

    #[OA\Delete(
        path: '/patients/{id}',
        summary: 'Eliminar paciente',
        security: [['bearerAuth' => []]],
        tags: ['Patients'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Eliminado'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->deletePatient->execute($id);
        return response()->json(['message' => 'Paciente eliminado correctamente.'], Response::HTTP_OK);
    }
}
