<template>
  <a href="/login" class="login-icon" title="Se connecter">
    <img src="/images/icons/login-icon.png" alt="Connexion" />
  </a>
</template>

<style scoped>
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
</style>
