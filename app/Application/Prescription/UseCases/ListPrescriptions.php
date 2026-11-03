<?php

declare(strict_types=1);

namespace App\Application\Prescription\UseCases;

use App\Domain\Prescription\Repositories\PrescriptionRepositoryInterface;

final class ListPrescriptions
{
    public function __construct(private readonly PrescriptionRepositoryInterface $repository) {}

    public function execute(int $page = 1, int $perPage = 20, ?int $patientId = null, ?int $medicationId = null): array
    {
        return $this->repository->findAll($page, $perPage, $patientId, $medicationId);
    }
}
