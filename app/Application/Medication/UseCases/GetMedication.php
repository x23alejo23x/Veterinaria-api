<?php

declare(strict_types=1);

namespace App\Application\Medication\UseCases;

use App\Domain\Medication\Entities\Medication;
use App\Domain\Medication\Repositories\MedicationRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class GetMedication
{
    public function __construct(
        private readonly MedicationRepositoryInterface $repository,
    ) {}

    public function execute(int $id): Medication
    {
        $medication = $this->repository->findById($id);

        if ($medication === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Medicación no encontrada.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $medication;
    }
}
