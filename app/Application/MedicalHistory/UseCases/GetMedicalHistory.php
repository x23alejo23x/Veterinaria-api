<?php

declare(strict_types=1);

namespace App\Application\MedicalHistory\UseCases;

use App\Domain\MedicalHistory\Entities\MedicalHistory;
use App\Domain\MedicalHistory\Repositories\MedicalHistoryRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class GetMedicalHistory
{
    public function __construct(
        private readonly MedicalHistoryRepositoryInterface $repository,
    ) {}

    public function execute(int $id): MedicalHistory
    {
        $record = $this->repository->findById($id);

        if ($record === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Registro no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $record;
    }
}
