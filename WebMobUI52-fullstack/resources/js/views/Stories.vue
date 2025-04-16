<script setup>
import { useFetchJson } from '@/composables/useFetchJson'

const { data: stories, error, loading } = useFetchJson('/stories')
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Toutes les histoires</h1>

    <div v-if="loading">Chargement...</div>
    <div v-else-if="error" class="text-red-500">Erreur : {{ error.statusText }}</div>

    <ul v-else>
      <li
        v-for="story in stories"
        :key="story.id"
        class="mb-3 p-3 bg-gray-100 rounded shadow"
      >
        <h2 class="text-lg font-semibold">{{ story.title }}</h2>
        <p class="text-sm">{{ story.summary }}</p>
      </li>
    </ul>
  </div>
</template>
