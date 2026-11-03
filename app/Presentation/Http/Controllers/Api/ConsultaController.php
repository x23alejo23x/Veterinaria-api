<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Api;

use App\Infrastructure\Persistence\Eloquent\Models\Consulta;
use App\Infrastructure\Persistence\Eloquent\Models\ConsultaExam;
use App\Infrastructure\Persistence\Eloquent\Models\ConsultaHospitalization;
use App\Presentation\Http\Requests\Consulta\StoreConsultaRequest;
use App\Presentation\Http\Requests\Consulta\UpdateConsultaRequest;
use App\Presentation\Http\Resources\ConsultaExamResource;
use App\Presentation\Http\Resources\ConsultaHospitalizationResource;
use App\Presentation\Http\Resources\ConsultaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class ConsultaController extends Controller
{
    // ── Consultas ────────────────────────────────────────────────────────────

    public function index(Request $request): JsonResponse
    {
        $query = Consulta::query()->orderByDesc('opened_at');

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->integer('patient_id'));
        }

        $paginator = $query->paginate(
            $request->integer('per_page', 20),
            ['*'],
            'page',
            $request->integer('page', 1)
        );

        return response()->json([
            'items'    => ConsultaResource::collection($paginator->items()),
            'total'    => $paginator->total(),
            'page'     => $paginator->currentPage(),
            'pageSize' => $paginator->perPage(),
        ]);
    }

    public function show(int $id): ConsultaResource
    {
        return new ConsultaResource(Consulta::findOrFail($id));
    }

    public function store(StoreConsultaRequest $request): JsonResponse
    {
        $consulta = Consulta::create([
            'patient_id'      => $request->integer('patient_id'),
            'appointment_id'  => $request->input('appointment_id'),
            'vet'             => $request->string('vet'),
            'chief_complaint' => $request->input('chief_complaint'),
            'diagnosis'       => $request->input('diagnosis'),
            'base_fee'        => (float) ($request->input('base_fee') ?? 0),
            'status'          => 'abierta',
            'opened_at'       => now(),
        ]);

        return (new ConsultaResource($consulta))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateConsultaRequest $request, int $id): ConsultaResource
    {
        $consulta = Consulta::findOrFail($id);

        $consulta->update([
            'vet'             => $request->string('vet'),
            'chief_complaint' => $request->input('chief_complaint'),
            'diagnosis'       => $request->input('diagnosis'),
            'base_fee'        => (float) ($request->input('base_fee') ?? $consulta->base_fee),
        ]);

        return new ConsultaResource($consulta->fresh());
    }

    public function destroy(int $id): JsonResponse
    {
        Consulta::findOrFail($id)->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function close(int $id): ConsultaResource
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->update(['status' => 'cerrada', 'closed_at' => now()]);
        return new ConsultaResource($consulta->fresh());
    }

    public function reopen(int $id): ConsultaResource
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->update(['status' => 'abierta', 'closed_at' => null]);
        return new ConsultaResource($consulta->fresh());
    }

    // ── Exámenes ─────────────────────────────────────────────────────────────

    public function indexExams(int $id): JsonResponse
    {
        Consulta::findOrFail($id);

        $exams = ConsultaExam::where('consulta_id', $id)->orderBy('id')->get();

        return response()->json([
            'items'    => ConsultaExamResource::collection($exams),
            'total'    => $exams->count(),
            'page'     => 1,
            'pageSize' => 100,
        ]);
    }

    public function storeExam(Request $request, int $id): JsonResponse
    {
        Consulta::findOrFail($id);

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:200'],
            'category'   => ['nullable', 'string', 'max:60'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'notes'      => ['nullable', 'string'],
        ]);

        $exam = ConsultaExam::create([...$validated, 'consulta_id' => $id]);

        return (new ConsultaExamResource($exam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function updateExam(Request $request, int $id, int $examId): ConsultaExamResource
    {
        $exam = ConsultaExam::where('consulta_id', $id)->findOrFail($examId);

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:200'],
            'category'   => ['nullable', 'string', 'max:60'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'notes'      => ['nullable', 'string'],
        ]);

        $exam->update($validated);

        return new ConsultaExamResource($exam->fresh());
    }

    public function destroyExam(int $id, int $examId): JsonResponse
    {
        ConsultaExam::where('consulta_id', $id)->findOrFail($examId)->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    // ── Hospitalización ───────────────────────────────────────────────────────

    public function showHospitalization(int $id): JsonResponse
    {
        Consulta::findOrFail($id);

        $hosp = ConsultaHospitalization::where('consulta_id', $id)->first();

        if (!$hosp) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => new ConsultaHospitalizationResource($hosp)]);
    }

    public function upsertHospitalization(Request $request, int $id): JsonResponse
    {
        Consulta::findOrFail($id);

        $validated = $request->validate([
            'days'          => ['required', 'integer', 'min:1'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'notes'         => ['nullable', 'string'],
        ]);

        $hosp = ConsultaHospitalization::updateOrCreate(
            ['consulta_id' => $id],
            $validated
        );

        $status = $hosp->wasRecentlyCreated ? Response::HTTP_CREATED : Response::HTTP_OK;

        return response()->json(['data' => new ConsultaHospitalizationResource($hosp)], $status);
    }

    public function destroyHospitalization(int $id): JsonResponse
    {
        ConsultaHospitalization::where('consulta_id', $id)->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
