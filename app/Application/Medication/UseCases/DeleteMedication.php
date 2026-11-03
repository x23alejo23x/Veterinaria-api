<?php

declare(strict_types=1);

namespace App\Application\Medication\UseCases;

use App\Domain\Medication\Repositories\MedicationRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class DeleteMedication
{
    public function __construct(
        private readonly MedicationRepositoryInterface $repository,
    ) {}

    public function execute(int $id): void
    {
        if ($this->repository->findById($id) === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Medicación no encontrada.'], Response::HTTP_NOT_FOUND)
            );
        }

        $this->repository->delete($id);
    }
}
