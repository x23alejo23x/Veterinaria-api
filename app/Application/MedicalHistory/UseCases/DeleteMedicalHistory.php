<?php

declare(strict_types=1);

namespace App\Application\MedicalHistory\UseCases;

use App\Domain\MedicalHistory\Repositories\MedicalHistoryRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class DeleteMedicalHistory
{
    public function __construct(
        private readonly MedicalHistoryRepositoryInterface $repository,
    ) {}

    public function execute(int $id): void
    {
        if ($this->repository->findById($id) === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Registro no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        $this->repository->delete($id);
    }
}
