<script setup>
// Vue Router pour récupérer les paramètres de l’URL et rediriger
import { useRouter, useRoute } from 'vue-router'

// Données centralisées des archétypes finaux (persona)
import { personaData } from '@/utils/personaData'

const router = useRouter()
const route = useRoute()

// Extraction du paramètre dynamique depuis l’URL : /story/:id/ending/:persona
const persona = route.params.persona

// Sécurisation : si l'archétype n'existe pas, rediriger vers la liste des histoires
if (!personaData[persona]) {
  router.replace('/stories')
}

// Récupération des infos liées à l’archétype (ou valeurs par défaut)
const personaLabel = personaData[persona]?.label ?? 'Inconnu'
const description = personaData[persona]?.description ?? ''
const imageUrl = personaData[persona]?.image ?? ''
const backgroundClass = personaData[persona]?.backgroundClass ?? 'background-default'

// Rejouer = revenir à la liste des histoires
function restart() {
  router.push('/stories')
}
</script>

<template>
  <!-- Fond personnalisé selon l'archétype -->
  <div :class="['ending-page', backgroundClass]">
    <div class="ending-container">
      <!-- Image du personnage -->
      <img
        :src="imageUrl"
        :alt="`Portrait du personnage ${personaLabel}`"
        class="persona-image"
      />

      <!-- Texte associé à la personnalité finale -->
      <div class="text-section">
        <h1>
          Tu es un·e <span class="persona-name">{{ personaLabel }}</span>
        </h1>
        <p class="description">{{ description }}</p>

        <!-- Bouton pour recommencer une aventure -->
        <button @click="restart" class="restart-button">Rejouer</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.ending-page {
  color: #fff;
  font-family: 'VT323', monospace;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 2rem;
  transition: background 0.3s ease;
}

.ending-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  max-width: 960px;
  width: 100%;
  gap: 2rem;
}

@media (min-width: 768px) {
  .ending-container {
    flex-direction: row;
    align-items: flex-start;
  }

  .text-section {
    margin-left: 2rem;
  }
}

.persona-image {
  width: 100%;
  max-width: 380px;
  image-rendering: pixelated;
  filter: drop-shadow(0 0 8px rgba(255, 177, 0, 0.6));
}

.text-section {
  text-align: center;
  max-width: 600px;
}

@media (min-width: 768px) {
  .text-section {
    text-align: left;
  }
}

.persona-name {
  color: #ffb100;
  font-size: 3rem;
}

.description {
  font-size: 1.6rem;
  margin: 1rem 0 2rem;
  line-height: 1.8;
}

.restart-button {
  font-size: 1.8rem;
  padding: 0.8rem 2rem;
  background: #ffb100;
  font-family: 'VT323', monospace;
  color: #22092c;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
  box-shadow: 0 0 10px rgba(255, 177, 0, 0.5);
}

.restart-button:hover {
  background: #e09a00;
}

.background-sorciere {
  background: #4b2e83;
}

.background-guerriere {
  background: #9c1b1b;
}

.background-fee {
  background: #3abbc9;
}

.background-reine {
  background: #3d2b1f;
}

.background-chevalier {
  background: #2a2e34;
}

.background-barde {
  background: #bb3601;
}

.background-dragon {
  background: #6a0d2f;
}

.background-paysan {
  background: #6b4f26;
}

.background-default {
  background: #22092c;
}
</style>
