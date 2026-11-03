<?php

declare(strict_types=1);

namespace App\Application\Appointment\UseCases;

use App\Domain\Appointment\DTOs\AppointmentDTO;
use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;
use DateTimeImmutable;

final class CreateAppointment
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $repository,
    ) {}

    public function execute(AppointmentDTO $dto): Appointment
    {
        $appointment = Appointment::create(
            patientId: $dto->patientId,
            ownerId: $dto->ownerId,
            date: new DateTimeImmutable($dto->date),
            time: $dto->time,
            type: $dto->type,
            status: $dto->status,
            vetId: $dto->vetId,
            notes: $dto->notes,
        );

        return $this->repository->save($appointment);
    }
}
