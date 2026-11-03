<?php

declare(strict_types=1);

namespace App\Application\FollowUp\UseCases;

use App\Domain\FollowUp\Repositories\FollowUpRepositoryInterface;

final class ListFollowUps
{
    public function __construct(
        private readonly FollowUpRepositoryInterface $repository,
    ) {}

    public function execute(int $page = 1, int $perPage = 20, ?string $status = null): array
    {
        return $this->repository->findAll($page, $perPage, $status);
    }
}
