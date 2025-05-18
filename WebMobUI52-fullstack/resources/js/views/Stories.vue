<script setup>

import { useFetchJson } from '@/composables/useFetchJson'
import { useRouter } from 'vue-router'
import LoginIcon from '@/components/LoginIcon.vue'
const { data: stories, error, loading } = useFetchJson('/stories')

const router = useRouter()

// Redirige l'utilisateur vers le premier chapitre d'une histoire
function openStory(story) {
  router.push(`/story/${story.id}`)
}
</script>

<template>
  <div class="page">
    <!-- Icône de connexion -->
    <LoginIcon />

    <!-- Titre principal -->
    <h1 class="title">Choisis ton aventure</h1>

    <!-- Affichage en cas de chargement -->
    <div v-if="loading" class="status">Chargement...</div>

    <!-- Affichage en cas d’erreur -->
    <div v-if="error" class="status error">Erreur : {{ error.statusText }}</div>

    <!-- Grille des histoires récupérées depuis l'API -->
    <div v-if="stories?.length" class="stories">
      <div
        v-for="story in stories"
        :key="story.id"
        class="story"
        @click="openStory(story)"
      >
        <!-- Illustration de l'histoire, avec fallback par défaut -->
        <img :src="story.cover || '/images/default-cover.jpg'" alt="" class="cover" />

        <!-- Titre et résumé de l’histoire -->
        <h2>{{ story.title }}</h2>
        <p>{{ story.summary }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page {
  background: #22092c;
  color: white;
  padding: 2rem;
  font-family: 'VT323', monospace;
  position: relative;
  min-height: 100vh;
}

.title {
  font-size: 3rem;
  text-align: center;
  margin-bottom: 2rem;
}

.status {
  text-align: center;
  font-size: 1.5rem;
  margin-bottom: 2rem;
}
.status.error {
  color: #ff6b6b;
}

.stories {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  justify-content: center;
}

.story {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  padding: 1rem;
  border-radius: 10px;
  width: 100%;
  max-width: 300px;
  cursor: pointer;
  transition: transform 0.3s;
  text-align: center;
}

.story:hover {
  transform: scale(1.03);
}

.cover {
  width: 100%;
  border-radius: 8px;
  margin-bottom: 1rem;
  object-fit: contain; 
  max-height: 300px;   
}
</style>
