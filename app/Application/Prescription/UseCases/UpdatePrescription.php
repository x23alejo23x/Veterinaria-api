<?php

declare(strict_types=1);

namespace App\Application\Prescription\UseCases;

use App\Domain\Prescription\DTOs\PrescriptionDTO;
use App\Domain\Prescription\Entities\Prescription;
use App\Domain\Prescription\Repositories\PrescriptionRepositoryInterface;

final class UpdatePrescription
{
    public function __construct(private readonly PrescriptionRepositoryInterface $repository) {}

    public function execute(int $id, PrescriptionDTO $dto): Prescription
    {
        return $this->repository->update($id, $dto);
    }
}
