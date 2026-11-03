<?php

declare(strict_types=1);

namespace App\Application\Owner\UseCases;

use App\Domain\Owner\DTOs\OwnerDTO;
use App\Domain\Owner\Entities\Owner;
use App\Domain\Owner\Repositories\OwnerRepositoryInterface;

final class CreateOwner
{
    public function __construct(
        private readonly OwnerRepositoryInterface $repository,
    ) {}

    public function execute(OwnerDTO $dto): Owner
    {
        $owner = Owner::create(
            name: $dto->name,
            email: $dto->email,
            phone: $dto->phone,
            city: $dto->city,
        );

        return $this->repository->save($owner);
    }
}
