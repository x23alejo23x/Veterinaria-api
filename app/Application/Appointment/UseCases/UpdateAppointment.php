<?php

declare(strict_types=1);

namespace App\Application\Appointment\UseCases;

use App\Domain\Appointment\DTOs\AppointmentDTO;
use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class UpdateAppointment
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $repository,
    ) {}

    public function execute(int $id, AppointmentDTO $dto): Appointment
    {
        if ($this->repository->findById($id) === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Cita no encontrada.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $this->repository->update($id, $dto);
    }
}
