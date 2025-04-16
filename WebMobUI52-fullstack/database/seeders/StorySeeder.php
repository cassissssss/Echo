<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Choice;

class StorySeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('seeders/story.json'));
        $storyData = json_decode($json, true);

        $story = Story::create([
            'title' => $storyData['title'],
            'summary' => $storyData['summary'],
            'author' => $storyData['author'],
            'cover' => $storyData['cover'] ?? null, // 👈 ici
        ]);


        $chapterIdMap = [];

        foreach ($storyData['chapters'] as $chapter) {
            $newChapter = Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => $chapter['chapter_number'],
                'content' => $chapter['content'],
            ]);

            $chapterIdMap[$chapter['chapter_number']] = $newChapter->id;
        }

        foreach ($storyData['chapters'] as $chapter) {
            $currentChapterId = $chapterIdMap[$chapter['chapter_number']];

            foreach ($chapter['choices'] as $choice) {
                Choice::create([
                    'chapter_id' => $currentChapterId,
                    'text' => $choice['text'],
                    'next_chapter_id' => $chapterIdMap[$choice['next_chapter']],
                ]);
            }
        }
    }
}
