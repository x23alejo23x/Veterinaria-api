<?php

declare(strict_types=1);

namespace App\Application\FollowUp\UseCases;

use App\Domain\FollowUp\Entities\FollowUp;
use App\Domain\FollowUp\Repositories\FollowUpRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class GetFollowUp
{
    public function __construct(
        private readonly FollowUpRepositoryInterface $repository,
    ) {}

    public function execute(int $id): FollowUp
    {
        $followUp = $this->repository->findById($id);

        if ($followUp === null) {
            throw new HttpResponseException(
                response()->json(['message' => 'Seguimiento no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $followUp;
    }
}
