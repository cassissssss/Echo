<template>
  <!-- Conteneur central avec design immersif -->
  <div class="intro-container">
    <!-- Icône de connexion placée en haut à droite -->
    <LoginIcon />

    <!-- Titre d’accueil de l’application -->
    <h1 class="title">Bienvenue sur Echo</h1>

    <!-- Sous-titre poétique pour donner le ton -->
    <p class="subtitle">Un lieu où vous suivez vos propres histoires...</p>

    <!-- Bouton pour commencer l’aventure → redirige vers /stories -->
    <router-link to="/stories" class="start-button">
      ➤ Commencer l’aventure
    </router-link>
  </div>
</template>

<script setup>
// Composant pour l’icône de connexion (placée en haut à droite de toutes les vues)
import LoginIcon from '@/components/LoginIcon.vue'
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=VT323&display=swap');

.intro-container {
  font-family: 'VT323', monospace;
  background-color: #22092C;
  color: #ffffff;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 2rem;
  text-align: center;
  overflow: hidden;
  box-sizing: border-box;
  position: relative;
}

.title {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  letter-spacing: 2px;
}

.subtitle {
  font-size: 1.25rem;
  margin-bottom: 2.5rem;
}

.start-button {
  font-size: 1.25rem;
  padding: 0.75rem 1.5rem;
  border: 2px solid #fff;
  border-radius: 5px;
  color: #ffffff;
  text-decoration: none;
  transition: background 0.2s ease;
}

.start-button:hover {
  background-color: #ffffff22;
}

@media (max-width: 480px) {
  .title {
    font-size: 2rem;
  }

  .subtitle {
    font-size: 1rem;
  }

  .start-button {
    font-size: 1rem;
    padding: 0.6rem 1.2rem;
  }
}
</style>
