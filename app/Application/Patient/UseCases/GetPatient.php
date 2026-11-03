<?php

declare(strict_types=1);

namespace App\Application\Patient\UseCases;

use App\Domain\Patient\Entities\Patient;
use App\Domain\Patient\Repositories\PatientRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class GetPatient
{
    public function __construct(
        private readonly PatientRepositoryInterface $repository,
    ) {}

    public function execute(int $id): Patient
    {
        $patient = $this->repository->findById($id);

        if ($patient === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Paciente no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $patient;
    }
}
