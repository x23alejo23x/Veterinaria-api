<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Application\ExamCatalog\UseCases\CreateExamCatalog;
use App\Application\ExamCatalog\UseCases\DeleteExamCatalog;
use App\Application\ExamCatalog\UseCases\GetExamCatalog;
use App\Application\ExamCatalog\UseCases\ListExamCatalog;
use App\Application\ExamCatalog\UseCases\UpdateExamCatalog;
use App\Domain\ExamCatalog\DTOs\ExamCatalogDTO;
use App\Presentation\Http\Requests\ExamCatalog\StoreExamCatalogRequest;
use App\Presentation\Http\Requests\ExamCatalog\UpdateExamCatalogRequest;
use App\Presentation\Http\Resources\ExamCatalogResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExamCatalogController extends Controller
{
    public function __construct(
        private readonly ListExamCatalog   $listExamCatalog,
        private readonly GetExamCatalog    $getExamCatalog,
        private readonly CreateExamCatalog $createExamCatalog,
        private readonly UpdateExamCatalog $updateExamCatalog,
        private readonly DeleteExamCatalog $deleteExamCatalog,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $result = $this->listExamCatalog->execute(
            page:    (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 50),
            search:  $request->get('search'),
        );

        return response()->json([
            'items'    => ExamCatalogResource::collection(collect($result['items'])),
            'total'    => $result['total'],
            'page'     => $result['page'],
            'pageSize' => $result['pageSize'],
        ]);
    }

    public function show(int $id): ExamCatalogResource
    {
        return new ExamCatalogResource($this->getExamCatalog->execute($id));
    }

    public function store(StoreExamCatalogRequest $request): JsonResponse
    {
        $dto  = ExamCatalogDTO::fromArray($request->validated());
        $exam = $this->createExamCatalog->execute($dto);

        return (new ExamCatalogResource($exam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateExamCatalogRequest $request, int $id): ExamCatalogResource
    {
        $dto  = ExamCatalogDTO::fromArray($request->validated());
        $exam = $this->updateExamCatalog->execute($id, $dto);

        return new ExamCatalogResource($exam);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->deleteExamCatalog->execute($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
