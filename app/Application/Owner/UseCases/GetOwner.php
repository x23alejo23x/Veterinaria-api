<?php

declare(strict_types=1);

namespace App\Application\Owner\UseCases;

use App\Domain\Owner\Entities\Owner;
use App\Domain\Owner\Repositories\OwnerRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class GetOwner
{
    public function __construct(
        private readonly OwnerRepositoryInterface $repository,
    ) {}

    public function execute(int $id): Owner
    {
        $owner = $this->repository->findById($id);

        if ($owner === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Propietario no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $owner;
    }
}
