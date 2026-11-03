<?php

declare(strict_types=1);

namespace App\Application\ExamCatalog\UseCases;

use App\Domain\ExamCatalog\Entities\ExamCatalog;
use App\Domain\ExamCatalog\Repositories\ExamCatalogRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

final class GetExamCatalog
{
    public function __construct(
        private readonly ExamCatalogRepositoryInterface $repository,
    ) {}

    public function execute(int $id): ExamCatalog
    {
        $exam = $this->repository->findById($id);

        if (!$exam) {
            throw new HttpResponseException(
                response()->json(['message' => 'Examen no encontrado.'], Response::HTTP_NOT_FOUND)
            );
        }

        return $exam;
    }
}
