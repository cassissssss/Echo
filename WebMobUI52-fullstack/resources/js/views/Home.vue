<template>
  <div class="intro-container">
    <a href="/login" class="login-icon" title="Se connecter">
  <img src="/images/icons/login-icon.png" alt="Connexion" />
</a>

    <h1 class="title">Bienvenue sur Echo</h1>
    <p class="subtitle">Un lieu ou vous suivez vos propres histoires...</p>
    <router-link to="/stories" class="start-button">
      ➤ Commencer l’aventure
    </router-link>
  </div>
</template>

<script setup>
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

/* Icône de connexion */
.login-icon {
  position: fixed;
  top: 1rem;
  right: 1rem;
  z-index: 1000;
}
.login-icon img {
  width: 32px;
  height: 32px;
  transition: opacity 0.3s;
}
.login-icon img:hover {
  opacity: 0.7;
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
