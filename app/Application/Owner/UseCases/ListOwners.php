<?php

declare(strict_types=1);

namespace App\Application\Owner\UseCases;

use App\Domain\Owner\Repositories\OwnerRepositoryInterface;

final class ListOwners
{
    public function __construct(
        private readonly OwnerRepositoryInterface $repository,
    ) {}

    public function execute(int $page = 1, int $perPage = 20, ?string $search = null): array
    {
        return $this->repository->findAll($page, $perPage, $search);
    }
}
