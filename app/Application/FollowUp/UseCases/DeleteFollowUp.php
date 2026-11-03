<?php

declare(strict_types=1);

namespace App\Application\FollowUp\UseCases;

use App\Domain\FollowUp\Repositories\FollowUpRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class DeleteFollowUp
{
    public function __construct(
        private readonly FollowUpRepositoryInterface $repository,
    ) {}

    public function execute(int $id): void
    {
        if ($this->repository->findById($id) === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Seguimiento no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        $this->repository->delete($id);
    }
}
