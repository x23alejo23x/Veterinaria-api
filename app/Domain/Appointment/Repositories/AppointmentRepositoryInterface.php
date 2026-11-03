<?php

declare(strict_types=1);

namespace App\Domain\Appointment\Repositories;

use App\Domain\Appointment\DTOs\AppointmentDTO;
use App\Domain\Appointment\Entities\Appointment;

interface AppointmentRepositoryInterface
{
    public function findById(int $id): ?Appointment;

    /** @return array{items: Appointment[], total: int} */
    public function findAll(int $page = 1, int $perPage = 20, ?string $status = null): array;

    public function findByPatient(int $patientId): array;

    public function save(Appointment $appointment): Appointment;

    public function update(int $id, AppointmentDTO $dto): Appointment;

    public function delete(int $id): void;
}
