<template>
  <div class="intro-container">
    <h1 class="title">Bienvenue sur Echo</h1>
    <p class="subtitle">Un lieu ou vous suivez vos propres histoires...</p>
    <router-link to="/stories" class="start-button">
  ➤ Commencer l’aventure
</router-link>
  </div>
</template>

<script setup>
// rien à faire ici pour l’instant
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

}

.title {
  font-size: 3rem;
  margin-bottom: 1rem;
  letter-spacing: 2px;
}

.subtitle {
  font-size: 1.5rem;
  margin-bottom: 3rem;
}

.start-button {
  font-size: 1.25rem;
  padding: 0.75rem 1.5rem;
  border: 2px solid #fff;
  border-radius: 5px;
  color: #ffffff;
  text-decoration: none;
  transition: background 0.2s;
}

.start-button:hover {
  background-color: #ffffff22;
}
</style>
