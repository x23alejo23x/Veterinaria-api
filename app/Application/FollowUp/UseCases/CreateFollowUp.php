<?php

declare(strict_types=1);

namespace App\Application\FollowUp\UseCases;

use App\Domain\FollowUp\DTOs\FollowUpDTO;
use App\Domain\FollowUp\Entities\FollowUp;
use App\Domain\FollowUp\Repositories\FollowUpRepositoryInterface;
use DateTimeImmutable;

final class CreateFollowUp
{
    public function __construct(
        private readonly FollowUpRepositoryInterface $repository,
    ) {}

    public function execute(FollowUpDTO $dto): FollowUp
    {
        $followUp = FollowUp::create(
            patientId: $dto->patientId,
            ownerId: $dto->ownerId,
            date: new DateTimeImmutable($dto->date),
            type: $dto->type,
            status: $dto->status,
            notes: $dto->notes,
        );

        return $this->repository->save($followUp);
    }
}
