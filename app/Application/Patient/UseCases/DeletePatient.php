<?php

declare(strict_types=1);

namespace App\Application\Patient\UseCases;

use App\Domain\Patient\Repositories\PatientRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class DeletePatient
{
    public function __construct(
        private readonly PatientRepositoryInterface $repository,
    ) {}

    public function execute(int $id): void
    {
        if (!$this->repository->existsById($id)) {
            throw new HttpResponseException(
                response()->json(['message' => 'Paciente no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        $this->repository->delete($id);
    }
}
