<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use Illuminate\Http\JsonResponse;

class StoryController extends Controller
{
    public function getStories(): JsonResponse
    {
        $stories = Story::with('chapters.choices')->get();
        return response()->json($stories);
    }

    public function getStory(Story $story): JsonResponse
    {
        $story->load('chapters.choices');
        return response()->json($story);
    }

    public function createStory(StoreStoryRequest $request): JsonResponse
    {
        $story = Story::create($request->validated());
        return response()->json($story, 201);
    }

    public function updateStory(UpdateStoryRequest $request, Story $story): JsonResponse
    {
        $story->update($request->validated());
        return response()->json($story);
    }

    public function deleteStory(Story $story): JsonResponse
    {
        $story->delete();
        return response()->json(['message' => 'Story deleted successfully']);
    }
}
