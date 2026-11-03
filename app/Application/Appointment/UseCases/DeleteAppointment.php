<?php

declare(strict_types=1);

namespace App\Application\Appointment\UseCases;

use App\Domain\Appointment\Repositories\AppointmentRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class DeleteAppointment
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $repository,
    ) {}

    public function execute(int $id): void
    {
        if ($this->repository->findById($id) === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Cita no encontrada.'], Response::HTTP_NOT_FOUND)
            );
        }

        $this->repository->delete($id);
    }
}
