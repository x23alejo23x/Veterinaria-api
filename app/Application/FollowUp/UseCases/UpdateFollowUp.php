<?php

declare(strict_types=1);

namespace App\Application\FollowUp\UseCases;

use App\Domain\FollowUp\DTOs\FollowUpDTO;
use App\Domain\FollowUp\Entities\FollowUp;
use App\Domain\FollowUp\Repositories\FollowUpRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class UpdateFollowUp
{
    public function __construct(
        private readonly FollowUpRepositoryInterface $repository,
    ) {}

    public function execute(int $id, FollowUpDTO $dto): FollowUp
    {
        if ($this->repository->findById($id) === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Seguimiento no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $this->repository->update($id, $dto);
    }
}
