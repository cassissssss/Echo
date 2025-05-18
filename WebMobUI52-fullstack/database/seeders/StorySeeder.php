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
        /**
         * Charge une histoire complète à partir d'un fichier JSON, uniquement si elle n'existe pas déjà.
         */
        $json = File::get(database_path('seeders/story.json'));
        $storyData = json_decode($json, true);

        // Vérifie si une histoire avec ce titre existe déjà
        if (Story::where('title', $storyData['title'])->exists()) {
            return; // Stoppe l'exécution du seeder si l’histoire est déjà en base
        }

        // Création de l'histoire principale
        $story = Story::create([
            'title' => $storyData['title'],
            'summary' => $storyData['summary'],
            'author' => $storyData['author'],
            'cover' => $storyData['cover'] ?? null,
        ]);

        // permet de relier les "chapter_number" du JSON aux IDs de la db
        $chapterIdMap = [];

        // Création des chapitres
        foreach ($storyData['chapters'] as $chapter) {
            $newChapter = Chapter::create([
                'story_id' => $story->id,
                'chapter_number' => $chapter['chapter_number'],
                'content' => $chapter['content'],
                'image' => $chapter['image'] ?? null,
                'is_ending' => $chapter['is_ending'] ?? false,
                'is_chest_room' => $chapter['is_chest_room'] ?? false
            ]);

            $chapterIdMap[$chapter['chapter_number']] = $newChapter->id;
        }

        // Création des choix pour chaque chapitre
        foreach ($storyData['chapters'] as $chapter) {
            $currentChapterId = $chapterIdMap[$chapter['chapter_number']];

            foreach ($chapter['choices'] as $choice) {
                Choice::create([
                    'chapter_id' => $currentChapterId,
                    'text' => $choice['text'],
                    'next_chapter_id' => $chapterIdMap[$choice['next_chapter_id']] ?? null,
                    'traits' => $choice['traits'] ?? null,
                ]);
            }
        }
    }
}
