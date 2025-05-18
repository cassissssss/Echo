<script setup>
// Vue Router : accéder aux paramètres de l’URL (storyId, chapterId)
import { onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

// Icône de connexion fixe en haut à droite
import LoginIcon from '@/components/LoginIcon.vue'

// Composable contenant toute la logique métier du chapitre (récupération, navigation, redirections, etc.)
import { useChapterLogic } from '@/composables/useChapterLogic'

const route = useRoute()

// Variables et fonctions fournies par le composable
const {
  data,              
  error,             
  showContent,       
  showEndingModal,   
  fetchChapter,      
  goToChapter,       
  continueStory,     
  restartStory       
} = useChapterLogic()

// Chargement initial au montage du composant
onMounted(() => {
  fetchChapter()
})

// Recharge le chapitre si le paramètre d’URL change
watch(() => route.params.chapterId, () => {
  fetchChapter()
})
</script>

<template>
  <div class="page">
    <!-- Icône de connexion en haut à droite -->
    <LoginIcon />

    <!-- Affichage d'une erreur si le chapitre est invalide ou non disponible -->
    <div v-if="error" class="info error">Erreur : {{ error.statusText }}</div>

    <!-- Transition d'apparition du contenu du chapitre -->
    <transition name="fade" mode="out-in">
      <div v-if="showContent" key="chapter-content" class="content">
        
        <!-- Affichage de l’image du chapitre, si présente -->
        <div v-if="data?.image || data?.chapter?.image" class="image-container">
          <img
            :src="data?.image || data?.chapter?.image"
            alt="Illustration du chapitre"
            class="scene-image"
          />
        </div>

        <!-- Texte principal du chapitre -->
        <div class="chapter-text">
          <p>{{ data.content ?? data.chapter?.content ?? 'Contenu indisponible.' }}</p>
        </div>

        <!-- Affichage des choix du joueur (si disponibles) -->
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

        <!-- Si aucun choix disponible : bouton torche ou coffre -->
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

    <!-- Modal de fin d’histoire (si ce n’est pas une salle de coffre) -->
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
