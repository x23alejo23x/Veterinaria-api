<?php

declare(strict_types=1);

namespace App\Application\Owner\UseCases;

use App\Domain\Owner\Repositories\OwnerRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class DeleteOwner
{
    public function __construct(
        private readonly OwnerRepositoryInterface $repository,
    ) {}

    public function execute(int $id): void
    {
        if ($this->repository->findById($id) === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Propietario no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        $this->repository->delete($id);
    }
}
