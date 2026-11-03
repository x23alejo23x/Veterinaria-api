<?php

declare(strict_types=1);

namespace App\Application\Prescription\UseCases;

use App\Domain\Prescription\Repositories\PrescriptionRepositoryInterface;

final class DeletePrescription
{
    public function __construct(private readonly PrescriptionRepositoryInterface $repository) {}

    public function execute(int $id): void
    {
        $this->repository->delete($id);
    }
}
