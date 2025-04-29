<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use Illuminate\Http\JsonResponse;

class ChapterController extends Controller
{
    public function index(): JsonResponse
    {
        $chapters = Chapter::with('choices')->get();

        return response()->json($chapters);
    }

    public function store(StoreChapterRequest $request): JsonResponse
    {
        $chapter = Chapter::create($request->validated());

        return response()->json($chapter, 201);
    }

    public function getChapter(int $id): JsonResponse
    {
        $chapter = Chapter::with('choices')->find($id);

        if (!$chapter) {
            return response()->json(['message' => 'Chapitre introuvable.'], 404);
        }

        return response()->json($chapter);
    }

    public function update(UpdateChapterRequest $request, Chapter $chapter): JsonResponse
    {
        $chapter->update($request->validated());

        return response()->json($chapter);
    }

    public function destroy(Chapter $chapter): JsonResponse
    {
        $chapter->delete();

        return response()->json(['message' => 'Chapter deleted successfully']);
    }
}
