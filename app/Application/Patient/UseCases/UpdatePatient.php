<?php

declare(strict_types=1);

namespace App\Application\Patient\UseCases;

use App\Domain\Patient\DTOs\PatientDTO;
use App\Domain\Patient\Entities\Patient;
use App\Domain\Patient\Repositories\PatientRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class UpdatePatient
{
    public function __construct(
        private readonly PatientRepositoryInterface $repository,
    ) {}

    public function execute(int $id, PatientDTO $dto): Patient
    {
        if (!$this->repository->existsById($id)) {
            throw new HttpResponseException(
                response()->json(['message' => 'Paciente no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $this->repository->update($id, $dto);
    }
}
