<template>
  <div class="page">
    <div v-if="error" class="info error">Erreur : {{ error.statusText }}</div>

    <transition name="fade" mode="out-in">
      <div v-if="showContent" key="chapter-content" class="content">
        <div v-if="data.image ?? data.chapter?.image" class="image-container">
          <img
            :src="data.image ?? data.chapter.image"
            alt="Illustration du chapitre"
            class="scene-image"
          />
        </div>

        <div class="chapter-text">
          <p>{{ data.content ?? data.chapter?.content ?? 'Contenu indisponible.' }}</p>
        </div>

        <div v-if="(data.choices ?? data.chapter?.choices)?.length" class="choices">
          <div
            v-for="choice in data.choices ?? data.chapter.choices"
            :key="choice.id"
            class="choice-link"
            @click="goToChapter(choice.next_chapter_id)"
          >
            {{ choice.text }}
          </div>
        </div>

        <div v-else class="play-wrapper">
          <button class="play-button" @click="continueStory" aria-label="Continuer">
            <svg xmlns="http://www.w3.org/2000/svg" height="64" viewBox="0 0 24 24" fill="white">
              <path d="M8 5v14l11-7z" />
            </svg>
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useFetchJson } from '@/composables/useFetchJson'

const route = useRoute()
const router = useRouter()

const data = ref(null)
const error = ref(null)
const showContent = ref(false)

async function fetchChapter() {
  showContent.value = false

  const storyId = route.params.storyId
  const chapterId = route.params.chapterId

  const endpoint = chapterId
    ? `/chapters/${chapterId}`
    : `/stories/${storyId}/first-chapter`

  const { data: d, error: e } = useFetchJson(endpoint)

  setTimeout(() => {
    data.value = d.value
    error.value = e.value
    showContent.value = true
  }, 300) // ➔ petit délai pour laisser la transition se faire
}

fetchChapter()
watch(() => route.params.chapterId, fetchChapter)

function goToChapter(nextId) {
  router.push(`/story/${route.params.storyId}/chapter/${nextId}`)
}

function continueStory() {
  const chapterIdParam = route.params.chapterId
  const currentChapterId = chapterIdParam ? parseInt(chapterIdParam) : 1
  const nextChapterId = currentChapterId + 1
  router.push(`/story/${route.params.storyId}/chapter/${nextChapterId}`)
}
</script>

<style scoped>
.page {
  background: #22092c;
  color: white;
  min-height: 100vh;
  font-family: 'VT323', monospace;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 1.2s ease, transform 1.2s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

.content {
  text-align: center;
  max-width: 700px;
  width: 100%;
}

.image-container {
  display: flex;
  justify-content: center;
  margin-bottom: 1.6rem;
}

.scene-image {
  max-width: 260px;
  width: 100%;
  border-radius: 12px;
}

.chapter-text {
  font-size: 1.8rem;
  line-height: 1.6;
  margin-bottom: 2rem;
  text-align: center;
}

.choices {
  display: flex;
  flex-direction: column;
  gap: 1.10rem;
  align-items: center;
}

.choice-link {
  cursor: pointer;
  color: #ffb100;
  font-size: 1.25rem;
}

.choice-link:hover {
  color: #9c6d00;
}

.play-wrapper {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}

.play-button {
  background: none;
  border: none;
  cursor: pointer;
  transition: transform 0.2s, fill 0.2s;
}

.play-button:hover svg {
  fill: #ffb100;
  transform: scale(1.2);
}

.info {
  font-size: 1.2rem;
  opacity: 0.8;
  text-align: center;
  margin-top: 1rem;
}

.error {
  color: #ff6b6b;
}
</style>
