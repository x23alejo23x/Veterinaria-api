<?php

declare(strict_types=1);

namespace App\Domain\Owner\Repositories;

use App\Domain\Owner\DTOs\OwnerDTO;
use App\Domain\Owner\Entities\Owner;

interface OwnerRepositoryInterface
{
    public function findById(int $id): ?Owner;

    /** @return array{items: Owner[], total: int} */
    public function findAll(int $page = 1, int $perPage = 20, ?string $search = null): array;

    public function save(Owner $owner): Owner;

    public function update(int $id, OwnerDTO $dto): Owner;

    public function delete(int $id): void;
}
