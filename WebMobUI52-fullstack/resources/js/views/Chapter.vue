<template>
  <div class="page">
    <div v-if="error" class="info error">Erreur : {{ error.statusText }}</div>

    <transition name="fade" mode="out-in">
      <div v-if="showContent" key="chapter-content" class="content">
        <div v-if="data?.image || data?.chapter?.image" class="image-container">
  <img
    :src="data?.image || data?.chapter?.image"
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
            @click="goToChapter(choice.next_chapter_id, choice.traits ?? [])"
          >
            {{ choice.text }}
          </div>
        </div>

        <div v-else class="play-wrapper">
          <button class="torch-button" @click="continueStory" aria-label="Continuer">
            <img
  :src="data?.is_chest_room ? '/images/icons/chest.png' : '/images/icons/torch.png'"
  :alt="data?.is_chest_room ? 'Ouvrir le coffre' : 'Continuer'"
  class="torch-icon"
/>
          </button>
        </div>
      </div>
    </transition>

    <!-- Modal de fin -->
    <transition name="fade">
      <div v-if="showEndingModal" class="modal-overlay">
        <div class="modal">
          <h2>FIN</h2>
          <p>Tu as terminé ton histoire</p>
          <p>Mais il reste d'autres chemins à explorer !</p>
          <button class="restart-button" @click="restartStory">
            Recommencer
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useFetchJson } from '@/composables/useFetchJson'
import { addTrait, getFinalPersonality, resetTraits } from '@/composables/usePersonalityTracker'

const route = useRoute()
const router = useRouter()

// storyId robuste : fallback à 1 si jamais route.params.storyId est vide
const storyId = ref(route.params.storyId ?? 1)

const data = ref(null)
const error = ref(null)
const showContent = ref(false)
const showEndingModal = ref(false)

function normalizePersona(str) {
  return str
    .normalize("NFD") 
    .replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
}

async function fetchChapter() {
  showContent.value = false
  showEndingModal.value = false

  const chapterId = route.params.chapterId

  const endpoint = chapterId
    ? `/chapters/${chapterId}`
    : `/story/${storyId.value}/first-chapter`

  const { data: d, error: e } = useFetchJson(endpoint)

  setTimeout(() => {
    data.value = d.value
    error.value = e.value
    showContent.value = true
  }, 300)
}

function goToChapter(nextId, traits) {
  const traitsArray =
    typeof traits === 'string'
      ? traits.split(',').map(t => t.trim())
      : Array.isArray(traits)
      ? traits
      : []

  if (traitsArray.length > 0) {
    traitsArray.forEach(trait => addTrait(trait))
    logTraits()
  }

  setTimeout(() => {
    router.push(`/story/${storyId.value}/chapter/${nextId}`)
  }, 100)
}

function continueStory() {
  const isEnding = data.value?.is_ending
  const hasChoices = data.value?.choices?.length > 0

  if (isEnding && !hasChoices) {
    if (data.value?.is_chest_room) {
      const persona = getFinalPersonality()
      const slug = normalizePersona(persona)
      router.push(`/story/${storyId.value}/ending/${slug}`)
    } else {
      showEndingModal.value = true
    }
  } else {
    const chapterIdParam = route.params.chapterId
    const currentChapterId = chapterIdParam ? parseInt(chapterIdParam) : 1
    const nextChapterId = currentChapterId + 1
    router.push(`/story/${storyId.value}/chapter/${nextChapterId}`)
  }
}

function restartStory() {
  console.log('Restarting story')
  resetTraits()
  router.push(`/story/${storyId.value}/chapter/1`)
}

function logTraits() {
  const cookie = document.cookie.split('; ').find(c => c.startsWith('echo_traits='))
  const chapterId = route.params.chapterId || 'début'

  if (cookie) {
    const traits = JSON.parse(decodeURIComponent(cookie.split('=')[1]))
    console.log(`🧠 Traits du joueur au chapitre ${chapterId} :`)
    console.table(traits)
  } else {
    console.info(`🆕 Aucun cookie trouvé. Nouvelle session au chapitre ${chapterId}.`)
  }
}

onMounted(() => {
  fetchChapter()
})

watch(() => route.params.chapterId, async () => {
  await fetchChapter()
})
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
  margin-bottom: 2rem;
}

.scene-image {
  max-width: 320px;
  width: 100%;
  border-radius: 12px;
  image-rendering: pixelated;
  border: 2px solid white;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  animation: fadeInImage 1.2s ease forwards;
  opacity: 0;
  transform: translateY(10px);
}

.scene-image:hover {
  transform: scale(1.05);
  box-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
}

@keyframes fadeInImage {
  to {
    opacity: 1;
    transform: translateY(0);
  }
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

.torch-button {
  background: none;
  border: none;
  cursor: pointer;
  animation: pulse 2s infinite ease-in-out;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: transform 0.2s ease;
}

.torch-icon {
  width: 48px;
  height: 48px;
  image-rendering: pixelated;
  filter: drop-shadow(0 0 6px #ffb100);
  transition: transform 0.3s ease;
}

.torch-button:hover .torch-icon {
  transform: scale(1.2);
}

@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(10, 10, 10, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 100;
}

.modal {
  background: #22092c;
  color: white;
  padding: 2rem;
  border-radius: 12px;
  max-width: 400px;
  text-align: center;
  font-size: 1.3rem;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
  animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.restart-button {
  margin-top: 1rem;
  padding: 0.6rem 1.2rem;
  font-size: 1.1rem;
  border: none;
  background: #ffb100;
  font-family: 'VT323', monospace;
  font-size: 1.5rem;
  color: #22092c;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}

.restart-button:hover {
  background: #e09a00;
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
