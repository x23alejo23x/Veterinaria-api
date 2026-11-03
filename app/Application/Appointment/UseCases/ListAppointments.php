<?php

declare(strict_types=1);

namespace App\Application\Appointment\UseCases;

use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;

final class ListAppointments
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $repository,
    ) {}

    public function execute(int $page = 1, int $perPage = 20, ?string $status = null): array
    {
        return $this->repository->findAll($page, $perPage, $status);
    }
}
