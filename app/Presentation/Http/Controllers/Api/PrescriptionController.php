<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\Prescription\UseCases\CreatePrescription;
use App\Application\Prescription\UseCases\DeletePrescription;
use App\Application\Prescription\UseCases\GetPrescription;
use App\Application\Prescription\UseCases\ListPrescriptions;
use App\Application\Prescription\UseCases\UpdatePrescription;
use App\Domain\Prescription\DTOs\PrescriptionDTO;
use App\Presentation\Http\Requests\Prescription\StorePrescriptionRequest;
use App\Presentation\Http\Requests\Prescription\UpdatePrescriptionRequest;
use App\Presentation\Http\Resources\PrescriptionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class PrescriptionController
{
    public function __construct(
        private readonly ListPrescriptions $listPrescriptions,
        private readonly GetPrescription $getPrescription,
        private readonly CreatePrescription $createPrescription,
        private readonly UpdatePrescription $updatePrescription,
        private readonly DeletePrescription $deletePrescription,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $result = $this->listPrescriptions->execute(
            page: (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 50),
            patientId: $request->get('patient_id') ? (int) $request->get('patient_id') : null,
            medicationId: $request->get('medication_id') ? (int) $request->get('medication_id') : null,
        );

        return response()->json([
            'data' => PrescriptionResource::collection(collect($result['items'])),
            'meta' => [
                'total'    => $result['total'],
                'page'     => $result['page'],
                'per_page' => $result['per_page'],
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(['data' => new PrescriptionResource($this->getPrescription->execute($id))]);
    }

    public function store(StorePrescriptionRequest $request): JsonResponse
    {
        $prescription = $this->createPrescription->execute(PrescriptionDTO::fromArray($request->validated()));
        return response()->json(['data' => new PrescriptionResource($prescription)], Response::HTTP_CREATED);
    }

    public function update(UpdatePrescriptionRequest $request, int $id): JsonResponse
    {
        $existing = $this->getPrescription->execute($id);
        $data = array_merge([
            'patient_id'    => $existing->patientId,
            'medication_id' => $existing->medicationId,
            'dose'          => $existing->dose,
            'frequency'     => $existing->frequency,
            'duration'      => $existing->duration,
            'notes'         => $existing->notes,
            'status'        => $existing->status,
            'vet'           => $existing->vet,
            'date'          => $existing->date,
        ], $request->validated());

        $prescription = $this->updatePrescription->execute($id, PrescriptionDTO::fromArray($data));
        return response()->json(['data' => new PrescriptionResource($prescription)]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->deletePrescription->execute($id);
        return response()->json(['message' => 'Prescripción eliminada correctamente.']);
    }
}
