<?php

declare(strict_types=1);

namespace App\Application\Prescription\UseCases;

use App\Domain\Prescription\Entities\Prescription;
use App\Domain\Prescription\Repositories\PrescriptionRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;

final class GetPrescription
{
    public function __construct(private readonly PrescriptionRepositoryInterface $repository) {}

    public function execute(int $id): Prescription
    {
        $p = $this->repository->findById($id);
        if (!$p) {
            throw new HttpResponseException(response()->json(['message' => 'Prescripción no encontrada.'], 404));
        }
        return $p;
    }
}
