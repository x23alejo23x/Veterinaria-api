<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\Appointment\UseCases\CreateAppointment;
use App\Application\Appointment\UseCases\DeleteAppointment;
use App\Application\Appointment\UseCases\GetAppointment;
use App\Application\Appointment\UseCases\ListAppointments;
use App\Application\Appointment\UseCases\UpdateAppointment;
use App\Domain\Appointment\DTOs\AppointmentDTO;
use App\Presentation\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Presentation\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Presentation\Http\Resources\AppointmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

final class AppointmentController
{
    public function __construct(
        private readonly ListAppointments $listAppointments,
        private readonly GetAppointment $getAppointment,
        private readonly CreateAppointment $createAppointment,
        private readonly UpdateAppointment $updateAppointment,
        private readonly DeleteAppointment $deleteAppointment,
    ) {}

    #[OA\Get(
        path: '/appointments',
        summary: 'Listar citas',
        security: [['bearerAuth' => []]],
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'page',     in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'status',   in: 'query', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lista paginada de citas'),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $result = $this->listAppointments->execute(
            page: (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 20),
            status: $request->get('status'),
        );

        return response()->json([
            'data' => AppointmentResource::collection(collect($result['items'])),
            'meta' => [
                'total'    => $result['total'],
                'page'     => $result['page'],
                'per_page' => $result['per_page'],
            ],
        ]);
    }

    #[OA\Get(
        path: '/appointments/{id}',
        summary: 'Obtener cita',
        security: [['bearerAuth' => []]],
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Cita'),
            new OA\Response(response: 404, description: 'No encontrado'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $appointment = $this->getAppointment->execute($id);
        return response()->json(['data' => new AppointmentResource($appointment)]);
    }

    #[OA\Post(
        path: '/appointments',
        summary: 'Crear cita',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['patient_id', 'scheduled_at', 'reason'],
                properties: [
                    new OA\Property(property: 'patient_id',    type: 'integer', example: 1),
                    new OA\Property(property: 'scheduled_at',  type: 'string',  format: 'date-time', example: '2025-06-01T10:00:00'),
                    new OA\Property(property: 'reason',        type: 'string',  example: 'Consulta general'),
                    new OA\Property(property: 'status',        type: 'string',  example: 'pending'),
                ]
            )
        ),
        tags: ['Appointments'],
        responses: [
            new OA\Response(response: 201, description: 'Cita creada'),
        ]
    )]
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        $appointment = $this->createAppointment->execute(AppointmentDTO::fromArray($request->validated()));
        return response()->json(['data' => new AppointmentResource($appointment)], Response::HTTP_CREATED);
    }

    #[OA\Put(
        path: '/appointments/{id}',
        summary: 'Actualizar cita',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'status', type: 'string'),
                ]
            )
        ),
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Cita actualizada'),
        ]
    )]
    public function update(UpdateAppointmentRequest $request, int $id): JsonResponse
    {
        $appointment = $this->updateAppointment->execute($id, AppointmentDTO::fromArray($request->validated()));
        return response()->json(['data' => new AppointmentResource($appointment)]);
    }

    #[OA\Delete(
        path: '/appointments/{id}',
        summary: 'Eliminar cita',
        security: [['bearerAuth' => []]],
        tags: ['Appointments'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Eliminado'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->deleteAppointment->execute($id);
        return response()->json(['message' => 'Cita eliminada correctamente.'], Response::HTTP_OK);
    }
}
