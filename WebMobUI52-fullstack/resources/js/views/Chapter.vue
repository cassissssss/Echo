<script setup>
import { useRoute, useRouter } from 'vue-router'
import { useFetchJson } from '@/composables/useFetchJson'

const route = useRoute()
const router = useRouter()

const storyId = route.params.storyId
const chapterId = route.params.chapterId

const endpoint = chapterId
  ? `/chapters/${chapterId}`
  : `/stories/${storyId}/first-chapter`

const { data, error, loading } = useFetchJson(endpoint)

function goToChapter(nextId) {
  router.push(`/story/${storyId}/chapter/${nextId}`)
}
</script>

<template>
  <div class="page">
    <h1 class="title">Chapitre</h1>

    <div v-if="loading" class="info">Chargement...</div>
    <div v-else-if="error" class="info error">Erreur : {{ error.statusText }}</div>

    <div v-else class="content">
      <p class="chapter-text">{{ data.content ?? data.chapter.content }}</p>

      <div v-if="data.choices?.length || data.chapter?.choices?.length" class="choices">
        <button
          v-for="choice in data.choices ?? data.chapter.choices"
          :key="choice.id"
          class="choice-button"
          @click="goToChapter(choice.next_chapter_id)"
        >
          {{ choice.text }}
        </button>
      </div>

      <div v-else class="info">🎉 Fin de l'histoire.</div>
    </div>
  </div>
</template>

<style scoped>
.page {
  background: #22092c;
  color: white;
  padding: 2rem;
  min-height: 100vh;
  font-family: 'VT323', monospace;
}

.title {
  font-size: 2.5rem;
  text-align: center;
  margin-bottom: 2rem;
}

.info {
  text-align: center;
  font-size: 1.2rem;
  opacity: 0.8;
}

.error {
  color: #ff6b6b;
}

.content {
  max-width: 600px;
  margin: 0 auto;
}

.chapter-text {
  font-size: 1.5rem;
  line-height: 1.6;
  margin-bottom: 2rem;
  text-align: center;
}

.choices {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.choice-button {
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid white;
  color: white;
  padding: 1rem;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1.25rem;
  transition: transform 0.2s, background 0.3s;
}

.choice-button:hover {
  background: #ffb100;
  color: black;
  transform: scale(1.02);
}
</style>
