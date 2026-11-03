<?php

declare(strict_types=1);

namespace App\Application\Owner\UseCases;

use App\Domain\Owner\DTOs\OwnerDTO;
use App\Domain\Owner\Entities\Owner;
use App\Domain\Owner\Repositories\OwnerRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class UpdateOwner
{
    public function __construct(
        private readonly OwnerRepositoryInterface $repository,
    ) {}

    public function execute(int $id, OwnerDTO $dto): Owner
    {
        if ($this->repository->findById($id) === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Propietario no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $this->repository->update($id, $dto);
    }
}
